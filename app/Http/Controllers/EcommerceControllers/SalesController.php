<?php

namespace App\Http\Controllers\EcommerceControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Validator;
use App\Helpers\ListingHelper;


use App\Models\DeliveryStatus;
use App\Models\SalesPayment;
use App\Models\SalesHeader;
use App\Models\SalesDetail;
use App\Models\Permission;
use App\Models\Page;


use Auth;

class SalesController extends Controller
{
    private $searchFields = ['order_number','response_code','updated_at1', 'updated_at2'];

    public function __construct()
    {
        Permission::module_init($this, 'sales_transaction');
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


        $listing = new ListingHelper('desc',10,'order_number',$customConditions);
        //$sales = $listing->simple_search(SalesHeader::class, $this->searchFields);

        $sales = SalesHeader::where('id','>','0');
        if(isset($_GET['startdate']) && $_GET['startdate']<>'')
            $sales = $sales->where('created_at','>=',$_GET['startdate']);
        if(isset($_GET['enddate']) && $_GET['enddate']<>'')
            $sales = $sales->where('created_at','<=',$_GET['enddate'].' 23:59:59');
        if(isset($_GET['search']) && $_GET['search']<>'')
            $sales = $sales->where('order_number','like','%'.$_GET['search'].'%');
        if(isset($_GET['customer_filter']) && $_GET['customer_filter']<>'')
            $sales = $sales->where('customer_name','like','%'.$_GET['customer_filter'].'%');
        if(isset($_GET['del_status']) && $_GET['del_status']<>'')
            $sales = $sales->where('delivery_status','like',''.$_GET['del_status'].'');
        $sales = $sales->orderBy('id','desc');
        $sales = $sales->paginate(1000000);

        $filter = $listing->get_filter($this->searchFields);
        $searchType = 'simple_search';

        return view('admin.ecommerce.sales.index',compact('sales','filter','searchType'));

    }

    public function store(Request $request)
    {
        //
    }

    public function destroy(Request $request)
    {
        $sale = SalesHeader::findOrFail($request->id_delete);
        $sale->update(['status' => 'CANCELLED', 'delivery_status' => 'CANCELLED']);

        return back()->with('success','Successfully deleted transaction');
    }

    public function update(Request $request)
    {

        $save = SalesPayment::create([
            'sales_header_id' => $request->id,
            'payment_type' => $request->payment_type,
            'amount' => $request->amount,
            'status'  => (isset($request->status) ? 'PAID' : 'UNPAID'),
            'payment_date'  => $request->payment_date,
            'receipt_number'  => $request->receipt_number,
            'created_by' => Auth::id()
        ]);

        $sales = SalesHeader::where('id',$request->id)->first();
        $totalPayment = SalesPayment::where('sales_header_id',$request->id)->sum('amount');
        $total = $totalPayment + $request->amount;
        if($total >= $sales->net_amount)
            $status = 'PAID';
        else $status = 'UNPAID';

        $save = SalesHeader::findOrFail($request->id)->update([
            'payment_status' => $status
        ]);

        return back()->with('success','Successfully updated payment!');
        //return $status;
    }

    public function show($id)
    {
        $sales = SalesHeader::where('id',$id)->first();
        $salesPayments = SalesPayment::where('sales_header_id',$id)->get();
        $salesDetails = SalesDetail::where('sales_header_id',$id)->get();
        $totalPayment = SalesPayment::where('sales_header_id',$id)->sum('amount');
        $totalNet = SalesHeader::where('id',$id)->sum('net_amount');
        if($totalNet <= $totalPayment)
        $status = 'PAID';
        else $status = 'UNPAID';

        return view('admin.ecommerce.sales.view',compact('sales','salesPayments','salesDetails','status'));
    }

    public function quick_update(Request $request)
    {
        $update = SalesHeader::findOrFail($request->pages)->update([
            'delivery_status' => $request->status
        ]);

        $order = SalesHeader::findOrFail($request->pages);
        //dd($order);
        $this->sms_update_order_status($order->customer_contact_number,$order);

        return back()->with('success','Successfully updated delivery status!');

    }

    public function delivery_status(Request $request)
    {
        $sales = explode(",", $request->del_id);
        foreach($sales as $sale){
            logger($sale);
            $update = SalesHeader::whereId($sale)->update([
                'delivery_status' => $request->delivery_status
            ]);

            $update_delivery_table = DeliveryStatus::create([
                'order_id' => $sale,
                'user_id' => Auth::id(),
                'status' => $request->delivery_status,
                'remarks' => $request->del_remarks
            ]);
        }

        $order = SalesHeader::findOrFail($request->del_id);

        //$this->sms_update_order_status($order->customer_contact_number,$order);

        return back()->with('success','Successfully updated delivery status!');

    }

    public function sms_update_order_status($number,$order){

        $message = "Your order #".$order->order_number." is now on ".strtoupper($order->delivery_status)." status -LydiasLechon";
        $apicode = "TR-JUNDR725076_39D3A";
        $url = 'https://www.itexmo.com/php_api/api.php';
        $itexmo = array('1' => $number, '2' => $message, '3' => $apicode);
        $param = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($itexmo),
            ),
        );
        $context  = stream_context_create($param);
       // return;
        return file_get_contents($url, false, $context);
    }

    public function view_payment($id)
    {
        $salesPayments = SalesPayment::where('sales_header_id',$id)->get();
        $totalPayment = SalesPayment::where('sales_header_id',$id)->sum('amount');
        $totalNet = SalesHeader::where('id',$id)->sum('net_amount');
        $remainingPayment = $totalNet - $totalPayment;

        return view('admin.ecommerce.sales.payment',compact('salesPayments','totalPayment','totalNet','remainingPayment'));
    }

    public function cancel_product(Request $request)
    {
        return $request;
    }

    public function payment_add_store(Request $request)
    {
        SalesPayment::create([
            'sales_header_id' => $request->sales_header_id,
            'payment_type' => $request->pamenty_mode,
            'amount' => $request->amount,
            'status' => 'PAID',
            'payment_date' => $request->payment_dt,
            'receipt_number' => $request->ref_no,
            'remarks' => $request->payment_remarks,
            'created_by' => Auth::id()
        ]);

        return back()->with('success','Payment has been added successfully.');
    }

    public function display_payments(Request $request){
        $input = $request->all();

        $payments = SalesPayment::where('sales_header_id',$request->id)->get();

        return view('admin.ecommerce.sales.added-payments-result',compact('payments'));
    }

    public function display_delivery(Request $request){

        $input = $request->all();

        $delivery = DeliveryStatus::where('order_id',$request->id)->get();

        return view('admin.ecommerce.sales.delivery_history',compact('delivery'));
    }

}
