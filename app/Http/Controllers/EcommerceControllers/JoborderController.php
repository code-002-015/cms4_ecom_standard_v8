<?php

namespace App\Http\Controllers\EcommerceControllers;

use App\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\ListingHelper;
use Carbon\Carbon;
use App\EcommerceModel\GiftCertificate;
use App\EcommerceModel\ProductionBranch;
use App\EcommerceModel\ProductionOrder;
use App\EcommerceModel\SalesPayment;
use App\EcommerceModel\SalesHeader;
use App\EcommerceModel\SalesDetail;
use App\EcommerceModel\JobOrder;
use App\EcommerceModel\Branch;
use App\Deliverablecities;
use App\User;
use App\Product;
use App\Sms;
use Auth;
use DateTime;
use Storage;

class JoborderController extends Controller
{
    public function __construct()
    {
        Permission::module_init($this, 'job_order');
    }

    private $searchFields = ['jo_number','customer_name'];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function check_dateneeded(Request $request)
    {
        $rem = 0;
        $err = '';

        $x = explode(" - ", $request->dateneeded);

        $tym24 = date("H:i", strtotime($x[1]));

        //check if time is between the operation time
        $current_time = $x[1];
        $open = "04:59";
        $close = "21:01";
        $date1 = new DateTime($tym24);
        $date2 = new DateTime($open);
        $date3 = new DateTime($close);
        if ($date1 > $date2 && $date1 < $date3){

        }
        else{
            $rem = 1;
            $err .= "<li>The time you've selected (".$x[1].") is beyond our operation time which is between 5AM - 9PM.</li>";
        }

        //check if time is more than 48 hrs
        $date = strtotime($x[0]." ".$x[1]);


        //logger($request);

        if($request->has_lechon == 2){
            if($date < time() + 259200) {
                $rem = 1;
                $err .= "<li>The date and time you've selected (".$request->dateneeded.") is less than 72 hours from now. Our standard processing time for lechon baka is atleast 72 hours. However, you can still proceed with your order by clicking the close button.</li>";
            }
        }
        if($request->has_lechon == 1){
            if($date < time() + 86400) {
                $rem = 1;
                $err .= "<li>The date and time you've selected (".$request->dateneeded.") is less than 24 hours from now. Our standard processing time is atleast 24 hours. However, you can still proceed with your order by clicking the close button.</li>";
            }
        }
        if($request->has_lechon == 0){
            if($date < time()) {
                $rem = 1;
                $err .= "<li>The date and time you've selected (".$request->dateneeded.") is invalid. Selecting past dates is not allowed.</li>";
            }
            if($date < time() + 7200) {
                $rem = 1;
                $err .= "<li>The date and time you've selected (".$request->dateneeded.") is less than 2 hours from now. Our standard processing time is atleast 2 hours. However, you can still proceed with your order by clicking the close button.</li>";
            }
        }



        return response()->json([
            'err' => $err,
            'remark' => $rem
        ]);

    }
    public function index()
    {
        

        $customConditions = [
                [
                    'field' => 'status',
                    'operator' => '=',
                    'value' => 'active',
                    'apply_to_deleted_data' => true
                ],
            ];

     
        if(auth()->user()->role_id == 1 || auth()->user()->role_id == 3){
            $model = Joborder::where('id','>',0);
               //logger($model->get());
        }else{
            $branches = \App\UserBranch::accessBranch();

            $locations = [];
            foreach($branches as $branch){
                array_push($locations, $branch->branch->name);
            }
            $model = Joborder::where('id','>',0)
                                ->where(function ($query) use($locations) {
                                    $query->whereIn('customer_address', $locations)
                                          ->orWhereIn('order_source', $locations);
                                });

        }
        $model = $this->additional_filters($model);

        $listing = new ListingHelper('desc', 10, 'updated_at', $customConditions);

        $joborders = $listing->simple_search_using_collection($model, $this->searchFields);

        // Simple search init data
        $filter = $listing->get_filter($this->searchFields);
        $searchType = 'simple_search';
        
        return view('admin.joborder.index',compact('joborders', 'filter', 'searchType'));
    }

    public function additional_filters($model){
    
        if(isset($_GET['order_source_filter']) && strlen($_GET['order_source_filter']) > 1){
            $model = $model->where('order_source','=',$_GET['order_source_filter']);        
        }       
        if(isset($_GET['start_date']) && strlen($_GET['start_date']) > 1){
            $model = $model->where('created_at','>=',$_GET['start_date'].' 00:00:00');        
        }
        if(isset($_GET['end_date']) && strlen($_GET['end_date']) > 1){
            $model = $model->where('created_at','<=',$_GET['end_date'].' 23:59:59');        
        }
        if(isset($_GET['dn_start_date']) && strlen($_GET['dn_start_date']) > 1){
            $d = SalesDetail::where('date_needed','>=',$_GET['dn_start_date'].' 00:00:00')->select('sales_header_id')->get();
            $model = $model->whereIn('id',$d);        
        }
        if(isset($_GET['dn_end_date']) && strlen($_GET['dn_end_date']) > 1){
            $d = SalesDetail::where('date_needed','<=',$_GET['dn_end_date'].' 23:59:59')->select('sales_header_id')->get();
            $model = $model->whereIn('id',$d);              
        }

        if(isset($_GET['delivery_method']) && strlen($_GET['delivery_method']) > 0){
            $model = $model->where('delivery_method','=',$_GET['delivery_method']);        
        }

        return $model;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $miscelaneous = Product::where('is_misc',1)->orderBy('name','asc')->get();
        $products = Product::where('production_item',1)->orderBy('name','asc')->get();
        $branches_store = Branch::orderBy('name','asc')->get();
        $branches  = Deliverablecities::distinct()->orderBy('name')->get(['name']);
        return view('admin.joborder.create',compact('products','miscelaneous','branches','branches_store'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function use_coupon($code,$sales_id){

        $coupon = GiftCertificate::whereCode($code)->whereStatus('Unused')->first();

        if(empty($coupon)){
            return false;
        }

        $use_coupon = $coupon->update([
            'status' => 'Used',
            'sales_header_id' => $sales_id,
            'isApproved' => '1',
            'approved_by' => Auth::user()->name,
            'approved_on' => date('Y-m-d')
        ]);

        return $coupon;
    }

    public function verify_coupon($code){

        $coupon = GiftCertificate::whereCode($code)->whereStatus('Unused')->first();

        if(empty($coupon)){
            return 0;
        }

        return 1;
    }

    public function store(Request $request)
    {
        $rdata = $request->all();
        if($request->totalcoupon > 0){
            $couponCode = $rdata['couponcode'];
            foreach($couponCode as $key => $coupon){
                $verify_coupon = $this->verify_coupon($coupon);
                if($verify_coupon == 0){
                    return back()->with('error','Coupon Code: '.$coupon.' has been used already');
                }
            }
        }

        $ran   = microtime();
        $today = getdate();
        $order_number = $today[0].substr($ran, 2,6);


        $bs = explode('|', $request->branch_source);

        if($request->customer_type == 'cs-new'){
            $todayd = getdate();
            $email_cs = $request->email ?? 'lydtmp_'.$todayd[0].substr(microtime(), 2,6).'@lydias.com';;
            $check_if_exist = User::where('email', '=', $email_cs)->first();
            if($check_if_exist === null){
                $customer = User::create([
                    'name' => $request->fname.' '.$request->lname,
                    'firstname' => $request->fname,
                    'lastname' => $request->lname,
                    'email' => $email_cs,
                    'user_type' => 'customer',
                    'address_street' => $request->house_no.' '.$request->street,
                    'address_municipality' => $request->barangay ?? '',
                    'address_city' => $request->city ?? '',
                    'registration_source' => $request->branch_source,
                    'contact_mobile' => $request->mobile,
                    'password' => \Hash::make('password', array('rounds'=>12)),
                    'is_active' => 1
                ]);
                $id  = $customer->id;
            }
            else{
                $id = $check_if_exist->id;
            }


            $name   = $request->fname.' '.$request->lname;
            $mobile = $request->mobile;
            $address= $request->house_no.' '.$request->street.' '.$request->barangay.' '.$request->city;
        } else {
            $id     = $request->customer_id;
            $name   = $request->customer_name;
            $mobile = $request->customer_mobile;
            $address= $request->customer_address;
        }

        if($request->delivery_type == 1){
            $outlet = explode('|',$request->outlet_d2d);
            $delivery_add = $request->add_ress;
            $pickup_store = '';
            $customer_location = $outlet[0];
        }
        else{
            $outlet = explode('|',$request->outlet_pickup);
            $delivery_add = $outlet[0];
            $pickup_store = $outlet[0];
            $customer_location = '';
        }

        $new_gross = $request->gross;
        $discount_amount = 0;
        $totalCouponDiscount = 0;

        if($request->totalcoupon > 0){
            $coupons = $rdata['coupondiscount'];
            foreach($coupons as $key => $discount){
                $totalCouponDiscount += $discount;
            }

            $new_gross = $request->gross + $totalCouponDiscount;
            $discount_amount = $totalCouponDiscount;
        }

        $salesHeader = SalesHeader::create([
            'user_id' => $id,
            'order_number' => $order_number,
            'response_code' => 'success',
            'order_source' => $bs[0] ?? 'Forecaster',
            'customer_name' => $name,
            'customer_contact_number' => $mobile,
            'customer_address' => $address,
            'customer_delivery_adress' => $delivery_add,
            'delivery_tracking_number' => '',
            'delivery_fee_amount' => $request->delivery_charge,
            'gross_amount' => $new_gross,
            'tax_amount' => 0,
            'discount_amount' => $discount_amount,
            'net_amount' => $request->gross,
            'payment_status' => $request->payment_method == 'Deposit' ? 'UNPAID' : 'PAID',
            'delivery_status' => '',
            'status' => 'active',
            'payment_date' => Carbon::today(),
            'delivery_type' => $request->delivery_type == 1 ? 'Door to door delivery' : 'Store Pickup',
            'outlet' => $pickup_store,
            'order_type' => $request->order_type,
            'currency' => 'PHP',
            'instruction' => $request->instruction,
            'payment_used' => $request->payment_method,
            'payment_remarks' => $request->payment_remarks,
            'customer_location' => $customer_location,
            'agent' => $request->agent ?? Auth::user()->name,
            'delivery_branch' => $request->delivery_type == 1 ? $request->delivery_branch : NULL,
            
        ]);


        if($salesHeader){
            $salesHeader->update([
                'order_number' => sprintf('%07d', $salesHeader->id)
            ]);
            //dd($request);
            $data = $request->all();
            if(!empty($data['product_id'])){
                $product_id = $data['product_id'];
                $order_qty  = $data['order_qty'];
                $paella_qty = $data['paella_qty'];
                foreach($product_id as $key => $id){
                   // logger($palla_qty[$key]);
                    $product = Product::find($id);
                    $this->save_product_to_sales_detail($salesHeader->id,$product,$order_qty[$key],$paella_qty[$key],$request);
                }
            }



            if($request->total_misc > 0){
                $misc_id    = $data['misc_id'];
                $misc_qty   = $data['misc_qty'];

                foreach($misc_id as $key => $id){
                    $product = Product::find($id);

                    $this->save_product_to_sales_detail($salesHeader->id,$product,$misc_qty[$key],0,$request);
                }
            }
                for($ix=1; $ix<=10; $ix++){

                    if($request->input('payment_amount'.$ix) > 0){

                        $image_url = '';
                        if($request->hasFile('payment_file'.$ix))
                        {
                            $newFile = $this->upload_file_to_storage('payments', $request->file('payment_file'.$ix));
                            $image_url = $newFile['url'];
                        }

                        //$is_cod = ($request->input('payment_method'.$ix) == 'COD') ? 'PENDING':'PAID';
                        $is_cod = 'PENDING';
                        $add_special_payment = SalesPayment::create([
                            'sales_header_id' => $salesHeader->id,
                            'payment_type' => $request->input('payment_method'.$ix),
                            'amount' => $request->input('payment_amount'.$ix),
                            'status' => $is_cod,
                            'payment_date' => date('Y-m-d'),
                            'receipt_number' => $request->input('payment_remarks'.$ix),
                            'created_by' => $salesHeader->user_id,
                            'file_url' => $image_url,
                            'order_number' => $salesHeader->order_number
                        ]);
                    }
                }
               // logger($add_special_payment);


            //if(strlen($request->couponcode)>=1){
            if($request->totalcoupon > 0){
                $couponDiscount = $rdata['coupondiscount'];
                $couponCode = $rdata['couponcode'];

                foreach($couponCode as $key => $coupon){
                    $use_coupon = $this->use_coupon($coupon,$salesHeader->id);
                    $payment_coupon = SalesPayment::create([
                        'sales_header_id' => $salesHeader->id,
                        'payment_type' => 'Gift Cert',
                        'amount' => $couponDiscount[$key],
                        'status' => 'PAID',
                        'payment_date' => date('Y-m-d'),
                        'receipt_number' => $coupon,
                        'created_by' => Auth::id()
                    ]);
                } 
            }

        }
        $sales = SalesHeader::whereId($salesHeader->id)->first();
        $total_payments = SalesPayment::where('sales_header_id',$salesHeader->id)->where('status','PAID')->sum('amount');
        if($total_payments >= $sales->gross_amount){
            $confirm_sales = SalesHeader::whereId($salesHeader->id)->update([
                'isConfirm' => 1,
                'confirmed_by' => Auth::user()->name,
                'confirm_remarks' => 'Auto confirm after payment completion',
                'confirmed_on' => date('Y-m-d H:i:s')
            ]);
        }

        //$sms = new Sms();
        //$sms->send_sms($salesHeader->customer_contact_number, 'new_order', $salesHeader);
        if(auth()->user()->role_id == 3)
            return redirect()->route('joborders.index')->with('success', __('standard.joborders.create_success'));        
        else
            return redirect()->route('sales-transaction.index')->with('success', __('standard.joborders.create_success'));
    }

    public function upload_file_to_storage($folder, $file, $key = '') {

        $fileName = $file->getClientOriginalName();
        if (Storage::disk('public')->exists($folder.'/'.$fileName)) {
            $fileNames = explode(".", $fileName);
            $count = 2;
            $newFilename = $fileNames[0].' ('.$count.').'.$fileNames[1];
            while(Storage::disk('public')->exists($folder.'/'.$newFilename)) {
                $count += 1;
                $newFilename = $fileNames[0].' ('.$count.').'.$fileNames[1];
            }

            $fileName = $newFilename;
        }

        $path = Storage::disk('public')->putFileAs($folder, $file, $fileName);
        $url = Storage::disk('public')->url($path);
        $returnArr = [
            'name' => $fileName,
            'url' => $url
        ];

        if ($key == '') {
            return $returnArr;
        } else {
            return $returnArr[$key];
        }
    }

    public function staff_edit_payment($id)
    {
        $details = SalesHeader::find($id);

        return view('admin.joborder.staff-update-payment',compact('details'));
    }

    public function staff_update_payment(Request $request)
    {
        $header = SalesHeader::find($request->header_id)->update([
            'payment_type' => $request->payment_type,
            'discount_amount' => $request->discount
        ]);

        if($header){
            SalesPayment::create([
                'sales_header_id' => $request->header_id,
                'payment_type' => $request->payment_type,
                'amount' => $request->deposit,
                'status' => 'posted',
                'payment_date' => Carbon::today(),
                'receipt_number' => '',
                'created_by' => auth()->id()
            ]);
        }

        return redirect(route('sales-transaction.index'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $details = SalesHeader::find($id);

        $miscelaneous = Product::where('is_misc',1)->orderBy('name','asc')->get();
        $products = Product::where('production_item',1)->orderBy('name','asc')->get();

        $ordered_products = SalesDetail::where('sales_header_id',$id)->get();
        $branches  = Deliverablecities::orderBy('name','asc')->get();

        return view('admin.joborder.edit',compact('products','miscelaneous','details','ordered_products','branches'));
    }

    public function delete_product(Request $request)
    {
        SalesDetail::where('sales_header_id',$request->header_id)->where('product_id',$request->product_id)->delete();

        return back()->with('success', __('standard.joborders.delete_product_success'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $outlet = explode('|',$request->outlet);
        $sales = SalesHeader::find($id);

        $update = $sales->update([
            'delivery_fee_amount' => $request->delivery_charge,
            'delivery_type' => $request->delivery_type == 1 ? 'door-to-door' : 'pick-up at store',
            'outlet' => $outlet[0] == 'others' ? $request->other_outlet : $outlet[0],
            'order_type' => $request->order_type,
            'instruction' => $request->instruction

        ]);

        if($update){
            $data = $request->all();
            $order_type = $data['ordertype'];
            $product_id = $data['product_id'];
            $order_qty  = $data['order_qty'];
            $paella_qty = $data['paella_qty'];

            foreach ($order_type as $key => $type) {
                if($type == 'old'){
                    SalesDetail::where('sales_header_id',$id)->where('product_id',$product_id[$key])->update([
                        'qty' => $order_qty[$key],
                        'paella_qty' => $paella_qty[$key]
                    ]);
                } else {
                    $product = Product::find($product_id[$key]);
                    $this->save_product_to_sales_detail($id,$product,$order_qty[$key],$paella_qty[$key],$request);
                }
            }

            if($request->total_misc > 0){
                $misc_id    = $data['misc_id'];
                $misc_qty   = $data['misc_qty'];

                foreach($misc_id as $key => $prod_id){
                    $product = Product::find($prod_id);

                    $this->save_product_to_sales_detail($id,$product,$misc_qty[$key],0,$request);
                }
            }
        }

        return redirect()->route('joborders.index')->with('success', __('standard.joborders.jo_update_success'));
    }

    public function save_product_to_sales_detail($salesHeaderID,$product,$qty,$paella_qty,$request)
    {
        //save_product_to_sales_detail($salesHeader->id,$id,$product,$order_qty[$key],$paella_qty[$key],$request)
        SalesDetail::create([
            'sales_header_id' => $salesHeaderID,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'product_category' => $product->category_id,
            'price' => $product->price,
            'paella_price' => $paella_qty > 0 ? ($product->paella_price*$paella_qty) : 0,
            'cost' => 0,
            'tax_amount' => 0,
            'promo_id' => 0,
            'promo_description' => '',
            'discount_amount' => 0,
            'gross_amount' => ($product->price*$qty) + ($product->paella_price*$paella_qty), // need further clarification about paella qty
            'net_amount' => ($product->price*$qty) + ($product->paella_price*$paella_qty),
            'qty' => $qty,
            'uom' => 'PC',
            'penalty' => 0,
            'status' => '',
            'delivery_date' => $request->delivery_date.' '.$request->delivery_time,
            'size' => 0,
            'no_of_pax' => 0,
            'paella_qty' => $paella_qty,
            'joborder_id' => 0,
            'created_by' => auth()->id()
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function display_customer_details(Request $request){
        $input = $request->all();
        
        //$details = SalesHeader::where('customer_name',$request->name)->orderBy('id','desc')->first();
        $details = User::where('name',$request->name)->first();
        logger($details);
        return view('admin.joborder.display-customer-details',compact('details'));

    }

    public function delete(Request $request){
        //dd($request);
        //SalesHeader::find($request->jo_id)->delete();
        //SalesDetail::where('sales_header_id',$request->jo_id)->delete();
        $del_jo = JobOrder::whereId($request->jo_id)->delete();
        ProductionOrder::where('joborder_id',$request->jo_id)->delete();
        return back()->with('success', __('standard.joborders.delete_success'));
    }

    public function create_pantaga_or_display()
    {
        $products = Product::where('production_item',1)->orderBy('name','asc')->get();
        $prod_branches = ProductionBranch::orderBy('name','asc')->get();
        $prod_stores   = Branch::orderBy('name','asc')->get();

        return view('admin.joborder.create-pantaga-or-display',compact('products','prod_branches','prod_stores'));
    }



    public function edit_pantaga_or_display($id)
    {
        $jo = Joborder::whereId($id)->first();
        $po = ProductionOrder::where('joborder_id',$id)->first();
        $products = Product::where('production_item',1)->orderBy('name','asc')->get();
        $prod_branches = ProductionBranch::orderBy('name','asc')->get();
        $prod_stores   = Branch::orderBy('name','asc')->get();

        return view('admin.joborder.update-pantaga-or-display',compact('products','prod_branches','prod_stores','jo','po'));
    }

    public function update_pantaga(Request $request)
    {
        
        $prodstore  = Branch::find($request->branch_id);
        $jo = JobOrder::whereId($request->jo_id)->update([
            'date_needed' => $request->date_needed.' '.$request->time_needed,
            'customer_address' => $prodstore->name,
            'customer_delivery_adress' => $prodstore->address,
            'pickup_branch' => $request->branch_id,
            'jo_category' => $request->jo_category,
            'jo_order_type' => $request->order_type,
            'qty' => $request->qty,
            'remarks' => $request->remarks
        ]);

        ProductionOrder::whereId($request->po_id)->update([
            'branch_id' => $request->prodbranch_id,
            'delivery_date' => $request->production_date.' '.$request->production_time
        ]);

        return redirect()->route('joborders.index')->with('success','Successfully updated Joborder');
    }

    public function store_pantaga_or_display(Request $request)
    {

      
        $product = Product::whereId($request->product_id)->withTrashed()->first();
        $x=0;
        $current_total_order = JobOrder::whereDate('date_needed',$request->production_date)->count();

        foreach($request->branch_id as $br){
            $x++;
            $insertID = $current_total_order+$x;
            $prodstore  = Branch::find($br);
            $jo = JobOrder::create([
                'user_id' => auth()->id(),
                'jo_number' => 'JO'.date('Ymd',strtotime($request->production_date)).sprintf('%04d', $insertID),
                'sales_detail_id' => 0,
                'order_source' => 'forecaster',
                'product_id' => $product->id,
                'product_name' => $product->name,
                'product_size' => $product->size,
                'product_weight' => $product->weight,
                'product_category' => $product->category_id,
                'date_needed' => $request->date_needed.' '.$request->time_needed,
                'customer_name' => '',
                'customer_address' => $prodstore->name,
                'customer_delivery_adress' => $prodstore->address,
                'customer_mobile_number' => '',
                'delivery_tracking_number' => '',
                'delivery_method' => $request->delivery_type,
                'pickup_branch' => $br,
                'delivery_status' => 'On Processed',
                'status' => 'Active',
                'jo_category' => $request->jo_category,
                'jo_order_type' => $request->order_type,
                'qty' => $request->qty,
                'remarks' => $request->remarks

            ]);
            // $jo->update([
            //     'jo_number' => 'JO'.sprintf('%07d', $jo->id)
            // ]);

            if($jo){
                $this->assign_to_production_branch($jo->id,$request);
            }
        }

        return redirect()->route('joborders.index')->with('success', __('standard.joborders.create_success'));
    }

    public function assign_to_production_branch($joId,$request)
    {
        ProductionOrder::create([
            'branch_id' => $request->prodbranch_id,
            'joborder_id' => $joId,
            'delivery_date' => $request->production_date.' '.$request->production_time,
            'schedule_type' => $request->order_type
        ]);
    }

    public function get_shipping_fee(Request $request){

        $rate=0;
        //$baka_with_fee = ['Imus Cavite','Molino'];
        $location_lechon = Deliverablecities::whereName($request->location)->where('item_type','lechon')->first();
        $location_misc = Deliverablecities::whereName($request->location)->where('item_type','misc')->first();

        if($request->has_lechon == '1' || $request->has_lechon == '2'){
            if(!empty($location_lechon)){
                $rate = $location_lechon->rate;
            }
        }
        else{
            if(!empty($location_misc)){
                $rate = $location_misc->rate;
            }
        }

        if($request->has_lechon == '2'){
            $rate = 0;
        }

        if($request->has_lechon == '2' && $location_lechon->outside_manila == 1){
             $rate = 3000;
        }

        if(!isset($rate)){
            $rate = 0 ;
        }

        return response()->json([
            'fee' => $rate
        ]);
    }
}
