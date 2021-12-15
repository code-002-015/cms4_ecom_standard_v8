<?php

namespace App\Http\Controllers\EcommerceControllers;

use App\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

use App\EcommerceModel\ProductionBranch;
use App\EcommerceModel\Branch;
use App\EcommerceModel\ProductionOrder;
use App\EcommerceModel\SalesDetail;
use App\EcommerceModel\SalesHeader;
use App\EcommerceModel\JobOrder;
use App\Product;


class ForecasterController extends Controller
{

    public function __construct()
    {
        Permission::module_init($this, 'forecaster');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function show_deliveries(Request $request)
    {
        $params = Input::all();

        return $this->index($params);
    }

    public function index($param = null)
    {
        $branches = ProductionBranch::orderBy('name','asc')->get();
        $orders = SalesDetail::whereIN('product_id', function($query){ $query->select('id')->from('products')->where('production_item',1); } )
            ->whereIN('sales_header_id', function($query){ $query->select('id')->from('ecommerce_sales_headers')->where('status','active')->where('isConfirm','1')->whereNull('deleted_at'); } )          
            ->where('Joborder_id',0)
            ->orderBy('delivery_date')
            ->get();

            //->where('delivery_date','>=',date('Y-m-d 00:00:00'))
        return view('admin.forecaster.index',compact('branches','orders','param'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'branch_id' => 'required',
            'schedule_type' => 'required',
            'delivery_date' => 'required',
            'delivery_time' => 'required'
        ])->validate();
        
        //$header = SalesHeader::find($request->header_id);
        $salesdetail = SalesDetail::find($request->sales_id);

        $current_total_order = JobOrder::whereDate('date_needed',$request->delivery_date)->count();
        $insertID = $current_total_order+1;
        //dd($current_total_order." aa ".$insertID." bb ".'JO'.date('Ymd',strtotime($request->delivery_date)).sprintf('%04d', $insertID));

        $jo = JobOrder::create([
            'user_id' => auth()->id(),
            'jo_number' => 'JO'.date('Ymd',strtotime($request->delivery_date)).sprintf('%04d', $insertID),
            'sales_number' => $salesdetail->header->order_number,
            'sales_detail_id' => $salesdetail->id,
            'order_source' => $salesdetail->header->order_source,
            'product_id' => $salesdetail->product_id,
            'product_name' => $salesdetail->product->name,
            'product_size' => $salesdetail->product->size,
            'product_weight' => $salesdetail->product->weight,
            'product_category' => $salesdetail->product->category_id,
            'price' => $salesdetail->price,
            'paella_qty' => $salesdetail->paella_qty,
            'qty' => $salesdetail->qty,
            'paella_price' => $salesdetail->paella_price,
            'customer_name' => $salesdetail->header->customer_name,
            'date_needed' => $request->delivery_date.' '.$request->delivery_time,
            'customer_mobile_number' => $salesdetail->header->customer_contact_number,
            'customer_tel_number' => $salesdetail->user->contact_tel,
            'customer_address' => $salesdetail->header->customer_address,
            'customer_delivery_adress' => $salesdetail->header->customer_delivery_adress,
            'delivery_tracking_number' => '',
            'delivery_method' => $salesdetail->header->delivery_type,
            'pickup_branch' => $request->receiver,
            'delivery_status' => 'On Processed',
            'status' => 'Active',
            'jo_category' => 'Order',
            'jo_order_type' => $salesdetail->header->order_type ?? ' '

        ]);

        if($jo){
            $this->assign_to_production_branch($jo->id,$request);
        }


        return redirect()->route('forecaster.index')->with('success', __('standard.forecaster.create_success'));

    }

    public function assign_to_production_branch($joId,$request)
    {
        ProductionOrder::create([
            'branch_id' => $request->branch_id,
            'joborder_id' => $joId,
            'delivery_date' => $request->delivery_date.' '.$request->delivery_time,
            'schedule_type' => $request->schedule_type
        ]);

        SalesDetail::where('id',$request->sales_id)->update(['Joborder_id' => $joId]);
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
        //
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
        //
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

    public function assign($id){
        $branches = ProductionBranch::orderBy('name','asc')->get();
        $receivers = Branch::orderBy('name','asc')->get();
        $sales_detail = SalesDetail::find($id);

        return view('admin.forecaster.assign',compact('sales_detail','branches','receivers'));
    }







    public function cancel(Request $request)
    {
        Validator::make($request->all(), [
            'reason' => 'required'
        ])->validate();
        $sales_data = SalesHeader::whereId($request->order_id)->first();
        $update = SalesHeader::whereId($request->order_id)->update([
            'instruction' => $sales_data->instruction.' TRANSACTION CANCELLED ('.$request->reason.')',
            'status' => 'CANCELLED'
        ]);
        $delete = SalesHeader::whereId($request->order_id)->delete();
        // $data = JobOrder::where('id',$request->order_id)->update([
        //     'status' => 'Cancelled',
        // ]);
        //$data = JobOrder::where('id',$request->order_id)->delete();

        return back()->with('success', __('standard.forecaster.cancel_success'));
    }

    public function show_orders($branch, $date)
    {
        $branch_data = ProductionBranch::where('id',$branch)->first();
        $branch_name = $branch_data->name;
        $orders = ProductionOrder::where('branch_id',$branch)->whereDate('delivery_date',$date)->get();

        return view('admin.forecaster.orders',compact('orders','branch_name'));

    }

    public function update_orders(Request $request)
    {
        Validator::make($request->all(), [
            'qty' => 'required'
        ])->validate();

        ProductionOrder::where('id',$request->order_id)->update(['qty' => $request->qty]);

        return back()->with('success', __('standard.forecaster.order_update_success'));
    }

    public function branch_cancel_order(Request $request)
    {
        ProductionOrder::where('id',$request->order_id)->delete();

        return back()->with('success', __('standard.forecaster.branch_cancel_order_success'));
    }

    public function display_orders(Request $request){
        $input = $request->all();

        $orders = ProductionOrder::where('branch_id',$request->branch_id)->whereDate('delivery_date',$request->date_needed)->orderBy('delivery_date','desc')->get();

        return view('admin.forecaster.display-assigned-orders',compact('orders'));
    }

    public function remove($id){
        
        $production_order = ProductionOrder::find($id);

        if($production_order->jobOrder_details->jo_category == 'Order'){
            SalesDetail::where('joborder_id',$production_order->joborder_id)->update(['joborder_id' => 0]);
        }

        JobOrder::find($production_order->joborder_id)->update(['status' => 'Cancelled']);
        $production_order->delete();
        JobOrder::find($production_order->joborder_id)->delete();

        return back()->with('success', __('standard.forecaster.remove_order_success'));
    }

    public function multiple_cancel(Request $request)
    {
        $orders = explode("|",$request->orders);

        foreach($orders as $order){
            JobOrder::whereId($order)->update(['status' => 'Cancelled' ]);
        }

        return back()->with('success', __('standard.forecaster.multiple_remove_order_success'));
    }
}
