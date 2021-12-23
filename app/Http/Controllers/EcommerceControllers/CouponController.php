<?php

namespace App\Http\Controllers\EcommerceControllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use App\Helpers\ListingHelper;


use App\Models\Coupon;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\User;
use App\Models\Deliverablecities;

use Carbon\Carbon;
use Auth;

use Response;

class CouponController extends Controller
{
    private $searchFields = ['name'];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listing = new ListingHelper('desc', 10, 'updated_at');

        $coupons = $listing->simple_search(Coupon::class, $this->searchFields);

        // Simple search init data
        $filter = $listing->get_filter($this->searchFields);
        $searchType = 'simple_search';

        return view('admin.ecommerce.coupon.index',compact('coupons', 'filter', 'searchType'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::where('status','PUBLISHED')->get();
        $categories =  ProductCategory::has('published_products')->where('status','PUBLISHED')->get();
        $brands = Product::whereNotNull('brand')->distinct()->get(['brand']);
        $customers = User::where('role_id',6)->where('is_active',1)->get();

        $locations = Deliverablecities::where('status','PUBLISHED')->get();
        $free_products = Product::where('category_id',87)->get();

        return view('admin.ecommerce.coupon.create',compact('products','categories','brands','customers','locations','free_products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'name' => 'required|max:150',
            'description' => 'required',
            'terms_and_conditions' => 'required',
            'customer' => $request->coupon_scope == 'specific' ? 'required' : '',
            'reward' => 'required',
            'code' => $request->coupon_activation == 'manual' && $request->creation_type == 'single' ? 'required|unique:coupons,coupon_code' : '',
            'reward' => 'required',
            'location' => $request->reward == 'free-shipping-optn' ? 'required' : '',
            'shipping_fee_discount_amount' => ($request->reward == 'free-shipping-optn' && $request->discount_type == 'partial') ? 'required' : '',
            'discount_amount' => $request->reward == 'discount-amount-optn' ? 'required' : '',
            'discount_percentage' => $request->reward == 'discount-percentage-optn' ? 'required' : '',
            'free_product_id' => $request->reward == 'free-product-optn' ? 'required' : '',
        ])->validate();


        $data = $request->all();

        if($request->coupon_activation == 'auto'){

            $ccode = Coupon::generate_unique_code();
            $scope_custid = NULL;

            if($request->coupon_scope == 'specific'){

                if(isset($request->customer)){
                    $customers = $data['customer'];
                    foreach($customers as $c){
                        $scope_custid .= $c.'|';
                    }
                }
            }

            $this->save_coupon($ccode,$scope_custid,$request);

        } else {

            if($request->creation_type == 'single'){

                $ccode = $request->code;
                $scope_custid = NULL;

                if($request->coupon_scope == 'specific'){

                    if(isset($request->customer)){
                        $customers = $data['customer'];
                        foreach($customers as $c){
                            $scope_custid .= $c.'|';
                        }
                    }
                }
                
                $this->save_coupon($ccode,$scope_custid,$request);

            } else {

                $csv = array();

                if(($handle = fopen($request->csv, 'r')) !== FALSE) {
                    set_time_limit(0);

                    $row = 0;
                    $counter = 0;
                    $msg = '';
                    $arr_coupons = [];
                    $arr_crows = [];
                    while(($dta = fgetcsv($handle, 5000, ',')) !== FALSE) {
                        $row++;
                        if($row > 1){

                            if(in_array($dta[0] ,$arr_coupons )){
                                $counter++;

                                $key = array_search($dta[0], $arr_coupons); // $key = 2;
                                $crow = $arr_crows[$key];

                                $msg .= 'Row #'.$row.': Found duplicate Coupon Code: '.$dta[0].' in Row #'.$crow.'.<br>';
                            } else {
                                array_push($arr_coupons, $dta[0]);
                                array_push($arr_crows, $row);
                            }

                            if($dta[1] == ''){
                                $counter++;
                                $msg .= 'Row #'.$row.': Email address is empty.<br>';
                            }

                            $coupon = Coupon::where('coupon_code',$dta[0])->where('status','ACTIVE')->count();
                            if($coupon > 0){
                                $counter++;
                                $msg .= 'Row #'.$row.': Coupon Code '.$dta[0].' is already in the list.<br>';
                            }

                            if($request->coupon_scope != 'all'){
                                $customers = explode(',',$dta[1]);
                                foreach($customers as $c){
                                    if($c != ''){
                                        if(User::where('email',str_replace(' ', '', $c))->where('is_active',1)->count() > 0){

                                        } else {
                                            $counter++; 
                                            $msg .= 'Row #'.$row.': '.$c.' is not active / unregistered.<br>';
                                        }
                                    }
                                }
                            }
                        }
                    }
                }

                if($counter == 0){
                   if(($handle = fopen($request->csv, 'r')) !== FALSE) {
                        // necessary if a large csv file
                        set_time_limit(0);

                        $row = 0;
                        while(($csvdata = fgetcsv($handle, 5000, ',')) !== FALSE) {
                            $row++;
                            // number of fields in the csv
                            $col_count = count($csvdata);
                            if($row > 1){
                                $scope_custid = NULL;
                                if($request->coupon_scope != 'all'){
                                    $customers = explode(',',$csvdata[1]);
                                    foreach($customers as $c){
                                        if($c != ''){
                                            $scope_custid .= $c.'|';
                                        }
                                    }
                                }
                                
                                $this->save_coupon($csvdata[0],$scope_custid,$request);
                            }
                        }
                        fclose($handle);
                    } 
                } else {
                    return back()->with('error', 'Failed to upload coupons.<br><br>Reason(s):<br>'.$msg);
                }
            }
        }


        return redirect(route('coupons.index'))->with('success','Coupon has been added.');
    }

    public function save_coupon($ccode,$customerIds,$request)
    {
        $data = $request->all();

        $loc = '';
        if($request->reward == 'free-shipping-optn'){
          
            $locations = $data['location'];
            $loc_discount_type = $request->discount_type;
            $loc_discount_amount = $request->shipping_fee_discount_amount;

            foreach($locations as $l){
                $loc .= $l.'|';
            }  
        } else {
            $loc = NULL;
            $loc_discount_type = NULL;
            $loc_discount_amount = 0;
        }

        $amount_discount = 1;
        if($request->reward == 'discount-amount-optn' || $request->reward == 'discount-percentage-optn'){
            $amount_discount = $request->amount_discount;
        }

        $discount_productid = NULL;
        if($request->product_discount == 'current'){
            $discount_productid = NULL;
        }

        if($request->product_discount == 'specific'){
            $discount_productid = $request->discount_productid;
        }

        if($request->coupon_scope == 'specific' || $request->coupon_scope == 'csv'){
            $cus_scope = 'specific';
        } else {
            $cus_scope = 'all';
        }

        $coupon = Coupon::create([
            'coupon_code' => $ccode,
            'name' => $request->name,
            'description' => $request->description,
            'terms_and_conditions' => $request->terms_and_conditions,
            'activation_type' => $request->coupon_activation,
            'customer_scope' => $cus_scope,
            'scope_customer_id' => $customerIds,
            'location' => $loc,
            'location_discount_type' => $loc_discount_type,
            'location_discount_amount' => $loc_discount_amount,
            'amount' => $request->reward == 'discount-amount-optn' ? $request->discount_amount : NULL,
            'percentage' => $request->reward == 'discount-percentage-optn' ? $request->discount_percentage : NULL,
            'free_product_id' => $request->free_product_id,
            'status' => ($request->has('status') ? 'ACTIVE' : 'INACTIVE'),
            'amount_discount_type' => $amount_discount,
            'product_discount' => $request->amount_discount == 2 ? $request->product_discount : NULL,
            'discount_product_id' => $discount_productid,
            'user_id' => Auth::id(),
        ]);

        if($coupon){
            $this->update_coupon_time_settings($coupon->id,$request);            
            $this->update_coupon_purchase_settings($coupon->id,$request);
            $this->update_coupon_rule_settings($coupon->id,$request);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function show(Coupon $coupon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function edit(Coupon $coupon)
    {
        $products = Product::where('status','PUBLISHED')->get();
        $categories =  ProductCategory::has('published_products')->where('status','PUBLISHED')->get();
        $brands = Product::whereNotNull('brand')->distinct()->get(['brand']);
        $customers = User::where('role_id',6)->where('is_active',1)->get();
        $locations = Deliverablecities::where('status','PUBLISHED')->get();
        $free_products = Product::where('category_id',87)->get();

        return view('admin.ecommerce.coupon.edit',compact('coupon','products','categories','brands','customers','locations','free_products'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Coupon $coupon)
    {
        Validator::make($request->all(), [
            'name' => 'required|max:150',
            'description' => 'required',
            'terms_and_conditions' => 'required',
            'customer' => $request->coupon_scope == 'specific' ? 'required' : '',
            'reward' => 'required',
            'code' => $request->coupon_activation == 'manual' ? 'required' : '',
            'reward' => 'required',
            'location' => $request->reward == 'free-shipping-optn' ? 'required' : '',
            'shipping_fee_discount_amount' => ($request->reward == 'free-shipping-optn' && $request->discount_type == 'partial') ? 'required|min:1' : '',
            'discount_amount' => $request->reward == 'discount-amount-optn' ? 'required' : '',
            'discount_percentage' => $request->reward == 'discount-percentage-optn' ? 'required' : '',
            'free_product_id' => $request->reward == 'free-product-optn' ? 'required' : '',

        ])->validate();

        $data = $request->all();

        $loc = '';
        if($request->reward == 'free-shipping-optn'){
          
            $locations = $data['location'];
            $loc_discount_type = $request->discount_type;
            $loc_discount_amount = $request->shipping_fee_discount_amount;

            foreach($locations as $l){
                $loc .= $l.'|';
            }  
        } else {
            $loc = NULL;
            $loc_discount_type = NULL;
            $loc_discount_amount = 0;
        }

        $customernames = '';
        if(isset($request->customer)){
            $customers = $data['customer'];
            foreach($customers as $c){
                $customernames .= $c.'|';
            }
        }

        $amount_discount = 1;
        if($request->reward == 'discount-amount-optn' || $request->reward == 'discount-percentage-optn'){
            $amount_discount = $request->amount_discount;
        }

        $discount_productid = NULL;
        if($request->product_discount == 'current'){
            $discount_productid = NULL;
        }

        if($request->product_discount == 'specific'){
            $discount_productid = $request->discount_productid;
        }

        Coupon::find($coupon->id)->update([
            'coupon_code' => $request->coupon_activation == 'manual' ? $request->code : Coupon::generate_unique_code(),
            'name' => $request->name,
            'description' => $request->description,
            'terms_and_conditions' => $request->terms_and_conditions,
            'activation_type' => $request->coupon_activation,
            'customer_scope' => $request->coupon_scope,
            'scope_customer_id' => $request->coupon_scope == 'specific' ? $customernames : NULL,
            'location' => $loc,
            'location_discount_type' => $loc_discount_type,
            'location_discount_amount' => $loc_discount_amount,
            'amount' => $request->reward == 'discount-amount-optn' ? $request->discount_amount : NULL,
            'percentage' => $request->reward == 'discount-percentage-optn' ? $request->discount_percentage : NULL,
            'free_product_id' => $request->free_product_id,
            'status' => ($request->has('status') ? 'ACTIVE' : 'INACTIVE'),
            'amount_discount_type' => $amount_discount,
            'product_discount' => $request->amount_discount == 2 ? $request->product_discount : NULL,
            'discount_product_id' => $discount_productid,
            'user_id' => Auth::id(),
        ]);

        if($coupon){
            
            $this->update_coupon_time_settings($coupon->id,$request);            
            $this->update_coupon_purchase_settings($coupon->id,$request);
            $this->update_coupon_rule_settings($coupon->id,$request);
        }

        return back()->with('success','Coupon details has been updated.');
    }

    public function update_coupon_time_settings($couponID,$request)
    {
        $starttime = Carbon::parse($request->starttime)->format('H:i');
        $endtime = Carbon::parse($request->endtime)->format('H:i');
        
        Coupon::find($couponID)->update([
            'start_date' => $request->coupon_time[0] == 'datetime' ? $request->startdate : NULL,
            'end_date' => $request->coupon_time[0] == 'datetime' ? $request->enddate : NULL,
            'start_time' => isset($request->starttime) ? $starttime : NULL,
            'end_time' => isset($request->endtime) ? $endtime : NULL,
            'event_name' => $request->coupon_time[0] == 'custom' ? $request->eventname : NULL,
            'event_date' => $request->coupon_time[0] == 'custom' ? $request->eventdate : NULL,
            'repeat_annually' => $request->has('repeat_annually') ? 1 : 0,
        ]);
    }

    public function update_coupon_purchase_settings($couponID,$request)
    {   
        $data = $request->all();
        $productnames = NULL;
        $productcategories = NULL;
        $productbrand = NULL;
        $totalamount = NULL;
        $totalqty = NULL;
        $amounttype = NULL;
        $qtytype = NULL;

        $coupon_combination_counter = 0;
        $coupon_combination = '';

        if($request->has('purchase_product')){
            $coupon_combination_counter++;
            if(isset($request->product_name)){
                $prodname = $data['product_name'];
                $coupon_combination .= 'product|';
                foreach($prodname as $prod){
                    $productnames .= $prod.'|';
                }
            }

            if(isset($request->product_brand)){
                $prodbrand = $data['product_brand'];
                $coupon_combination .= 'product|';
                foreach($prodbrand as $brand){
                    $productbrand .= $brand.'|';
                }
            } else{
               if(isset($request->product_category)){
                    $prodcat = $data['product_category'];
                    $coupon_combination .= 'product|';
                    foreach($prodcat as $cat){
                        $productcategories .= $cat.'|';
                    }
                } 
            }
            
        }

        if($request->has('purchase_total_amount')){
            $coupon_combination .= 'amount|';
            $coupon_combination_counter++;
            $totalamount = $request->purchase_amount;
            $amounttype = $request->amount_opt;
        }

        if($request->has('purchase_total_qty')){
            $coupon_combination .= 'qty|';
            $coupon_combination_counter++;
            $totalqty = $request->purchase_qty;
            $qtytype = $request->qty_opt;
        }

        Coupon::find($couponID)->update([
            'purchase_product_id' => $productnames,
            'purchase_product_cat_id' => $productcategories,
            'purchase_product_brand' => $productbrand,
            'purchase_amount' => $totalamount,
            'purchase_qty' =>  $totalqty,
            'purchase_amount_type' => $amounttype,
            'purchase_qty_type' =>  $qtytype,
            'purchase_combination_counter' => $coupon_combination_counter,
            'purchase_combination' => $coupon_combination
        ]);
    }

    public function update_coupon_rule_settings($couponID,$request)
    {
        Coupon::find($couponID)->update([
            'customer_limit' => isset($request->customer_limit) ? $request->coupon_customer_limit_qty : 100000,
            'combination' => ($request->has('combination')) ? 1 : 0,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function destroy(Coupon $coupon)
    {
        //
    }

    public function update_status($id,$status)
    {
        Coupon::find($id)->update([
            'status' => $status,
            'user_id' => Auth::id()
        ]);

        return back()->with('success', __('standard.coupons.status_update_success', ['STATUS' => $status]));
    }

    public function single_delete(Request $request)
    {
        $coupon = Coupon::findOrFail($request->coupons);
        $coupon->update([ 'user' => Auth::id() ]);
        $coupon->delete();

        return back()->with('success', __('standard.coupons.single_delete_success'));
    }

    public function restore($coupon){
        Coupon::withTrashed()->find($coupon)->update(['status' => 'INACTIVE','user_id' => Auth::id() ]);
        Coupon::whereId($coupon)->restore();

        return back()->with('success', __('standard.coupons.restore_promo_success'));
    }

    public function multiple_change_status(Request $request)
    {
        $coupons = explode("|", $request->coupons);

        foreach ($coupons as $coupon) {
            $publish = Coupon::where('status', '!=', $request->status)->whereId($coupon)->update([
                'status'  => $request->status,
                'user_id' => Auth::id()
            ]);
        }

        return back()->with('success',  __('standard.coupons.multiple_status_update_success', ['STATUS' => $request->status]));
    }

    public function multiple_delete(Request $request)
    {
        $coupons = explode("|",$request->coupons);

        foreach($coupons as $coupon){
            Coupon::whereId($coupon)->update(['user_id' => Auth::id() ]);
            Coupon::whereId($coupon)->delete();
        }

        return back()->with('success', __('standard.coupons.multiple_delete_success'));
    }

    public function download_coupon_template()
    {
        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=".date('mdY')."_coupons.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );


        $columns = array("Coupon Code", "Customer Emails (must exist in the customer list)");

        $callback = function() use ($columns)
        {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

}
