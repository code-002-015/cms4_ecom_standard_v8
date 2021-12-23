<?php

namespace App\Http\Controllers\EcommerceControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Validator;
use App\Helpers\ListingHelper;



use App\Models\ProductCategory;
use App\Models\DeliveryStatus;
use App\Models\SalesPayment;
use App\Models\SalesDetail;
use App\Models\SalesHeader;
use App\Models\CouponSale;
use App\Models\Product;
use App\Models\User;

use Auth;
use DB;


class ReportsController extends Controller
{
    public function product_list(Request $request)
    {
        
        $rs = Product::all();        

        return view('admin.reports.product.list',compact('rs'));

    }

    public function customer_list(Request $request)
    {
        
        $rs = User::where('role_id','6')->get();        

        return view('admin.reports.customer.list',compact('rs'));

    }

    public function inventory_reorder_point(Request $request)
    {
        
        $rs = Product::where('reorder_point','>',0)->get();
        

        return view('admin.reports.inventory.inventory_reorder_point',compact('rs'));

    }

    public function inventory_list(Request $request)
    {
        
        $rs = Product::all();
        

        return view('admin.reports.inventory.list',compact('rs'));

    }

    public function sales_list(Request $request)
    {
        
        $qry= "SELECT h.*,d.*,h.created_at as hcreated,h.id as hid,p.category_id,c.name as catname,p.brand,p.code,pay.payment_date as pdate,p.brand FROM `ecommerce_sales_details` d 
            left join ecommerce_sales_headers h on h.id=d.sales_header_id 
            left join ecommerce_sales_payments pay on pay.sales_header_id=d.sales_header_id
            left join products p on p.id=d.product_id 
            left join product_categories c on c.id=p.category_id
            where h.id>0 and h.status<>'CANCELLED' and h.delivery_status<>'CANCELLED'
            ";
       
        // else{
        //     $qry = "SELECT h.*,d.*,h.created_at as hcreated,h.id as hid,p.category_id,c.name as catname,p.brand,p.code FROM `ecommerce_sales_details` d left join ecommerce_sales_headers h on h.id=d.sales_header_id left join products p on p.id=d.product_id left join product_categories c on c.id=p.category_id where h.id>0 and h.status<>'CANCELLED' and h.delivery_status<>'CANCELLED'";
        // }

        if(isset($_GET['brand']) && $_GET['brand']<>''){
            $qry.= " and p.brand='".$_GET['brand']."'";
        }
        if(isset($_GET['customer']) && $_GET['customer']<>''){
            $qry.= " and h.customer_name='".$_GET['customer']."'";
        }
        if(isset($_GET['product']) && $_GET['product']<>''){
            $qry.= " and d.product_id='".$_GET['product']."'";
        }
        if(isset($_GET['category']) && $_GET['category']<>''){
            $qry.= " and p.category_id='".$_GET['category']."'";
        }
        if(isset($_GET['payment_status']) && $_GET['payment_status']<>''){
            $qry.= " and h.payment_status='".$_GET['payment_status']."'";
        }
        if(isset($_GET['del_status']) && $_GET['del_status']<>''){
            $qry.= " and h.delivery_status='".$_GET['del_status']."'";
        }
      
        if(isset($_GET['start']) && strlen($_GET['start'])>=1){
             $qry.= " and h.created_at >='".$_GET['start']." 00:00:00.000' and h.created_at <='".$_GET['end']." 23:59:59.999'";
            
        }

        
        //dd($qry);

        $rs = DB::select($qry. " ORDER BY h.id desc");

        return view('admin.reports.sales.list',compact('rs'));

    }

    public function sales_summary(Request $request)
    {
        
        $qry = "SELECT *,created_at as hcreated,id as hid FROM ecommerce_sales_headers where status<>'CANCELLED' and delivery_status<>'CANCELLED'";

       
        if(isset($_GET['customer']) && $_GET['customer']<>''){
            $qry.= " and customer_name='".$_GET['customer']."'";
        }
        if(isset($_GET['delivery_status']) && $_GET['delivery_status']<>''){
            $qry.= " and delivery_status='".$_GET['delivery_status']."'";
        }    
      
       

        if(isset($_GET['startdate']) && strlen($_GET['startdate'])>=1){
            $qry.= " and created_at >='".$_GET['startdate']." 00:00:00.000' and created_at <='".$_GET['enddate']." 23:59:59.999'";
        }
        //dd($qry);

        $rs = DB::select($qry);

        return view('admin.reports.sales.summary',compact('rs'));

    }

    public function unpaid_list(Request $request)
    {
        $rs = '';
        if(isset($_GET['act'])){
            $rs = DB::select("SELECT h.*,d.*,h.created_at as hcreated           
                    FROM `ecommerce_sales_details` d 
                    left join ecommerce_sales_headers h on h.id=d.sales_header_id 
                    where h.payment_status='UNPAID' and h.delivery_status<>'CANCELLED' and h.status<>'CANCELLED'
                     ");
        }

        return view('admin.reports.sales.unpaid',compact('rs'));

    }

    public function sales_payments(Request $request)
    {
        $qry = "SELECT h.*,d.*,h.created_at as hcreated           
                    FROM `ecommerce_sales_payments` d 
                    left join ecommerce_sales_headers h on h.id=d.sales_header_id 
                    where h.payment_status='PAID'
                     ";
        if(isset($_GET['start']) && strlen($_GET['start'])>=1){
            $qry.= " and d.payment_date >='".$_GET['start']."' and d.payment_date <='".$_GET['end']."'";
        }
            $rs = DB::select($qry);
    

        return view('admin.reports.sales.payment',compact('rs'));

    }


    public function sales(Request $request)
    {
        $rs = '';
        if(isset($_GET['act'])){
            $rs = DB::select("SELECT h.*,d.*,h.created_at as hcreated           
                    FROM `ecommerce_sales_details` d 
                    left join ecommerce_sales_headers h on h.id=d.sales_header_id 
                    where h.payment_status='PAID' order by h.id desc
                     ");
        }

        return view('admin.reports.sales',compact('rs'));

    }


    public function delivery_report($id)
    {
        $rs = SalesHeader::whereId($id)->first();
        
        return view('admin.ecommerce.reports.delivery_report',compact('rs'));

    }
    public function delivery_status(Request $request)
    {
        $rs = '';
       // if(isset($_GET['act'])){

            $rs = DB::select("SELECT h.*,d.*,h.created_at as hcreated           
                    FROM `ecommerce_sales_details` d 
                    left join ecommerce_sales_headers h on h.id=d.sales_header_id 
                    where h.payment_status='PAID'
                     ");

        //}

        return view('admin.reports.delivery_status',compact('rs'));

    }


    public function sales_per_customer(Request $request)
    {   
        $qry = "SELECT h.*,d.*,h.created_at as hcreated           
                FROM `ecommerce_sales_details` d 
                left join ecommerce_sales_headers h on h.id=d.sales_header_id 
                where h.payment_status='PAID'";

        if(isset($_GET['agent']) && strlen($_GET['agent'])>=1){
            $qry.= " and h.customer_name='".$_GET['agent']."'";
        }

        if(isset($_GET['startdate']) && strlen($_GET['startdate'])>=1){
            $qry.= " and h.created_at >='".$_GET['startdate']." 00:00:00.000' and h.created_at <='".$_GET['enddate']." 23:59:59.999'";
        }

        $rs = DB::select($qry);

        $customers = SalesHeader::distinct()->get(['customer_name']);

        return view('admin.reports.sales_per_customer',compact('rs','customers'));
    }

    public function stock_card(Product $id)
    {
     
        $rs = '';   

        $sales = \DB::table('ecommerce_sales_details')
                ->leftJoin('ecommerce_sales_headers', 'ecommerce_sales_details.sales_header_id', '=', 'ecommerce_sales_headers.id')
                ->where('ecommerce_sales_details.product_id','=',$id->id)
                ->where('ecommerce_sales_headers.payment_status','=','PAID')
                ->where('ecommerce_sales_headers.status','=','active')
                ->select('ecommerce_sales_headers.created_at as created', 'ecommerce_sales_details.qty as qty','ecommerce_sales_headers.order_number as ref',
                    \DB::raw('"sales" as type'))
                ->get();

        $inventory = \DB::table('inventory_receiver_details')
                ->leftJoin('inventory_receiver_header', 'inventory_receiver_details.header_id', '=', 'inventory_receiver_header.id')
                ->where('inventory_receiver_details.product_id','=',$id->id)
                ->where('inventory_receiver_header.status','=','POSTED')
                ->select('inventory_receiver_header.posted_at as created', 'inventory_receiver_details.inventory as qty','inventory_receiver_header.id as ref',
                    \DB::raw('"inventory" as type'))
                ->get();

        $rs = $sales->merge($inventory)->sortBy('created');
       
        return view('admin.reports.product.stockcard',compact('rs','id'));

    }

    public function coupon_list(Request $request)
    {
        $qry = "SELECT h.*,c.*, cs.coupon_code, cs.customer_id FROM `coupon_sales` cs 
            left join ecommerce_sales_headers h on h.id = cs.sales_header_id 
            left join coupons c on c.id = cs.coupon_id
            where cs.id > 0";

       
        if(isset($_GET['coupon_code']) && $_GET['coupon_code']<>''){
            $qry.= " and cs.coupon_code = '".$_GET['coupon_code']."' ";
        }

        if(isset($_GET['customer']) && strlen($_GET['customer'])>=1){
            $qry.= " and cs.customer_id = '".$_GET['customer']."' ";
        }

        if(isset($_GET['start']) && strlen($_GET['start'])>=1){
            $qry.= " and h.created_at >='".$_GET['start']."' and h.created_at <='".$_GET['end']."'";
        }
   
      
        $rs = DB::select($qry);

        return view('admin.reports.coupon.list',compact('rs'));

    }

  

}
