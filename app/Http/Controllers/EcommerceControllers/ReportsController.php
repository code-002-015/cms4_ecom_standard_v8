<?php

namespace App\Http\Controllers\EcommerceControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ListingHelper;

use App\EcommerceModel\ProductionBranch;
use App\EcommerceModel\GiftCertificate;
use App\EcommerceModel\DeliveryStatus;
use App\EcommerceModel\SalesPayment;
use App\EcommerceModel\SalesHeader;
use App\EcommerceModel\SalesDetail;
use App\EcommerceModel\JobOrder;
use App\EcommerceModel\Branch;
use App\ProductCategory;
use App\Permission;
use App\Product;

use Carbon\Carbon;
use Auth;
use DB;

class ReportsController extends Controller
{
    public function __construct()
    {
        Permission::module_init($this, 'reports');
    }

    public function sales(Request $request)
    {
        $qry = "SELECT pb.name as prod_branch,jo.jo_number as jnum,h.*,d.*,h.created_at as hcreated,h.id as hid,p.category_id,c.name as catname,d.id as did,
            IF(p.is_misc=1, 'Miscellaneous', c.name) as item_type
            FROM `ecommerce_sales_details` d
            left join ecommerce_sales_headers h on h.id=d.sales_header_id
            left join products p on p.id=d.product_id
            left join product_categories c on c.id=p.category_id
            left join job_orders jo on jo.sales_detail_id = d.id
            left join production_orders po on po.joborder_id = jo.id
            left join production_branches pb on pb.id = po.branch_id
         where h.id>0 and h.deleted_at is null and jo.deleted_at is null";
        // conditions
            if(isset($_GET['agent']) && $_GET['agent']<>''){
                $qry.= " and h.agent='".$_GET['agent']."'";
            }
            if(isset($_GET['customer']) && $_GET['customer']<>''){
                $qry.= " and h.customer_name='".$_GET['customer']."'";
            }
            if(isset($_GET['product']) && $_GET['product']<>''){
                $qry.= " and d.product_name='".$_GET['product']."'";
            }
            if(isset($_GET['category']) && $_GET['category']<>''){
                $qry.= " and p.category_id='".$_GET['category']."'";
            }
            if(isset($_GET['order_source']) && $_GET['order_source']<>''){
                $qry.= " and h.order_source='".$_GET['order_source']."'";
            }

            if(isset($_GET['item_type']) && $_GET['item_type']<>''){
                $qry.= " and IF(p.is_misc=1, 'Miscellaneous', c.name)='".$_GET['item_type']."'";
            }


            if(isset($_GET['startdate']) && strlen($_GET['startdate'])>=1){
                $qry.= " and h.created_at >='".date('Y-m-d',strtotime($_GET['startdate']))." 00:00:00.000' and h.created_at <='".date('Y-m-d',strtotime($_GET['enddate']))." 23:59:59.999'";
            }
            else{
                $qry.= " and h.created_at >='2050-01-01 00:00:00.000'";
            }
        // end conditions

        $rs = DB::select($qry);
       
        return view('admin.reports.sales',compact('rs'));

    }
    public function sales_transaction(Request $request)
    {
        $qry = "SELECT distinct h.*,h.id as hid,h.created_at as hcreated
            FROM `ecommerce_sales_details` d
            left join ecommerce_sales_headers h on h.id=d.sales_header_id
            left join products p on p.id=d.product_id
            left join product_categories c on c.id=p.category_id
            left join job_orders jo on jo.sales_detail_id = d.id
            left join production_orders po on po.joborder_id = jo.id
            left join production_branches pb on pb.id = po.branch_id
         where h.id>0 and h.deleted_at is null and jo.deleted_at is null";
        // conditions
            if(isset($_GET['agent']) && $_GET['agent']<>''){
                $qry.= " and h.agent='".$_GET['agent']."'";
            }
            if(isset($_GET['customer']) && $_GET['customer']<>''){
                $qry.= " and h.customer_name='".$_GET['customer']."'";
            }
            if(isset($_GET['product']) && $_GET['product']<>''){
                $qry.= " and d.product_name='".$_GET['product']."'";
            }
            if(isset($_GET['category']) && $_GET['category']<>''){
                $qry.= " and p.category_id='".$_GET['category']."'";
            }
            if(isset($_GET['order_source']) && $_GET['order_source']<>''){
                $qry.= " and h.order_source='".$_GET['order_source']."'";
            }


            if(isset($_GET['startdate']) && strlen($_GET['startdate'])>=1){
                $qry.= " and h.created_at >='".date('Y-m-d',strtotime($_GET['startdate']))." 00:00:00.000' and h.created_at <='".date('Y-m-d',strtotime($_GET['enddate']))." 23:59:59.999'";
            }
            else{
                $qry.= " and h.created_at >='2050-01-01 00:00:00.000'";
            }
        // end conditions

        $rs = DB::select($qry);
        
        return view('admin.reports.sales-transaction',compact('rs'));

    }

    public function forecaster(Request $request)
    {
        /*SELECT h.*,d.*,po.delivery_date as hcreated,h.id as hid,p.category_id,c.name as catname,h.agent,pb.name as pbname, h.delivery_status as delstat,
        po.delivery_date as deldate, h.delivery_type,h.instruction, jo.jo_number,br.name as receiver,p.is_misc,u.name as username, jo.jo_order_type, u.address_street, u.address_municipality, u.address_city, u.address_region, IF(p.is_misc=1, 'Miscellaneous', c.name) as item_type,p.is_misc,p.production_item,*/

        $qry = "SELECT d.product_name, d.paella_price,
        d.qty, h.order_number, u.address_street, u.address_municipality, u.address_city, u.address_region,d.price, h.customer_delivery_adress,
        h.customer_name, d.delivery_date as delivery_date, h.instruction, po.delivery_date as deldate, h.delivery_type, jo.jo_number, pb.name as pbname, h.delivery_status as delstat,h.agent, h.customer_contact_number,'' as dr, h.delivery_fee_amount, d.price, '' as releasing, h.order_source, br.name as receiver, c.name as catname, u.name as username, jo.jo_order_type,h.order_type as hordertype, IF(p.is_misc=1, 'Miscellaneous', c.name) as item_type, h.id as hid, '' as jo_category, 'sales' as trantype, DATE_FORMAT(d.delivery_date,'%H:%i:%s') as timeneeded, DATE_FORMAT(d.delivery_date, '%Y-%m-%d') as dateneeded, p.is_misc, p.production_item, h.isConfirm as isConfirm, h.gross_amount as gros, h.forecast_date as forecast_dt, h.delivery_branch as del_branch
        FROM `ecommerce_sales_details` d
        left join ecommerce_sales_headers h on h.id=d.sales_header_id
        left join products p on p.id=d.product_id
        left join product_categories c on c.id=p.category_id
        left join job_orders jo on jo.sales_detail_id = d.id
        left join branches br on  br.id = jo.pickup_branch
        left join production_orders po on po.joborder_id = jo.id
        left join production_branches pb on pb.id = po.branch_id
        left join users u on u.id = d.created_by
        where h.id>0 and h.deleted_at is null and jo.deleted_at is null and po.deleted_at is null and (h.payment_status = 'PAID' OR h.isConfirm=1)";

        if(isset($_GET['agent']) && $_GET['agent']<>''){
            $qry.= " and h.agent='".$_GET['agent']."'";
        }
        if(isset($_GET['customer']) && $_GET['customer']<>''){
            $qry.= " and h.customer_name='".$_GET['customer']."'";
        }
        if(isset($_GET['product']) && $_GET['product']<>''){
            $qry.= " and d.product_name='".$_GET['product']."'";
        }
        if(isset($_GET['category']) && $_GET['category']<>''){
            $qry.= " and p.category_id='".$_GET['category']."'";
        }
        if(isset($_GET['order_source']) && $_GET['order_source']<>''){
            $qry.= " and h.order_source='".$_GET['order_source']."'";
        }
        if(isset($_GET['production_branch']) && $_GET['production_branch']<>''){
            $qry.= " and pb.id='".$_GET['production_branch']."'";
        }


       if(isset($_GET['receiver']) && $_GET['receiver']<>''){

            $br = \App\EcommerceModel\Branch::whereId($_GET['receiver'])->first();

            $qry.= " and ((h.delivery_type='Store Pickup' and h.customer_delivery_adress='".$br->name."') or 

            (jo.pickup_branch='".$_GET['receiver']."' OR h.delivery_branch='".$br->name."')

            )";
        }


        if(isset($_GET['startdate']) && strlen($_GET['startdate'])>=1){
            $qry.= " and d.delivery_date >='".date('Y-m-d',strtotime($_GET['startdate']))." 00:00:00.000' and d.delivery_date <='".date('Y-m-d',strtotime($_GET['enddate']))." 23:59:59.999'";
        }
        else{
            $qry.= " and d.delivery_date >='2051-01-01 00:00:00.000' and d.delivery_date <='2051-01-01 23:59:59.999'";
        }
        if(isset($_GET['start_time']) && $_GET['start_time']<>''){ 
            $qry.= " and time(d.delivery_date)='".$_GET['start_time']."'";
        }
        if(isset($_GET['item_type']) && $_GET['item_type']<>''){
            $qry.= " and IF(p.is_misc=1, 'Miscellaneous', c.name)='".$_GET['item_type']."'";
        }
        //return $qry;
        $qry.= " order by d.delivery_date,customer_name,order_number";
        $rs = DB::select($qry);
        //dd($rs);
        // Pantaga created by forecaster
        // SELECT jo.*,p.category_id,c.name as catname,pb.name as pbname, p.name as product_name,po.delivery_date as deldate,br.name as receiver,jo.remarks as joremarks,u.name as username, jo.jo_order_type, u.address_street, u.address_municipality, u.address_city, u.address_region,
        //     IF(p.is_misc=1, 'Miscellaneous', c.name) as item_type,p.is_misc,p.production_item from job_orders jo 

        $jos = "
            SELECT jo.jo_category as product_name, '' as paella_price,'' as hordertype,
        jo.qty as qty, '' as order_number, u.address_street, u.address_municipality, u.address_city, u.address_region, jo.price, jo.customer_address as customer_delivery_adress,
        jo.customer_name, jo.date_needed as delivery_date,jo.remarks as instruction, po.delivery_date as deldate,'' as delivery_type, jo.jo_number, pb.name as pbname, 

        '' as delstat, '' as agent, '' as customer_contact_number,'' as dr, '0' as delivery_fee_amount,'0' as price, '' as releasing, 'Forecaster' as order_source, br.name as receiver, c.name as catname, u.name as username, jo.jo_order_type, IF(p.is_misc=1, 'Miscellaneous', c.name) as item_type, '0' as hid, jo.jo_category as jo_category, 'jo' as trantype, DATE_FORMAT(jo.date_needed,'%H:%i:%s') as timeneeded, DATE_FORMAT(jo.date_needed, '%Y-%m-%d') as dateneeded, p.is_misc, p.production_item, '1' as isConfirm, 0 as gros, '' as forecast_dt, '' as del_branch
        from job_orders jo 
        left join branches br on  br.id = jo.pickup_branch
        left join production_orders po on po.joborder_id = jo.id
        left join production_branches pb on pb.id = po.branch_id
        left join products p on p.id=jo.product_id
        left join product_categories c on c.id=p.category_id
        left join users u on u.id = jo.user_id
        where jo.id>0 and jo.deleted_at is null and po.deleted_at is null and (jo.sales_detail_id=0 or jo.sales_detail_id is null)";

        if(isset($_GET['product']) && $_GET['product']<>''){
            $jos.= " and p.name='".$_GET['product']."'";
        }
        if(isset($_GET['category']) && $_GET['category']<>''){
            $jos.= " and p.category_id='".$_GET['category']."'";
        }        
        if(isset($_GET['production_branch']) && $_GET['production_branch']<>''){
            $jos.= " and pb.id='".$_GET['production_branch']."'";
        }
        if(isset($_GET['startdate']) && strlen($_GET['startdate'])>=1){
            $jos.= " and po.delivery_date >='".date('Y-m-d',strtotime($_GET['startdate']))." 00:00:00.000' and po.delivery_date <='".date('Y-m-d',strtotime($_GET['enddate']))." 23:59:59.999'";
        }
        else{
            $jos.= " and po.delivery_date >='2051-01-01 00:00:00.000' and po.delivery_date <='2051-01-01 23:59:59.999'";
        }
        if(isset($_GET['start_time']) && $_GET['start_time']<>''){
            $jos.= " and time(po.delivery_date)='".$_GET['start_time']."'";
        }
        if(isset($_GET['receiver']) && $_GET['receiver']<>''){
            $jos.= " and jo.pickup_branch='".$_GET['receiver']."'";
        }

        if(isset($_GET['customer']) && $_GET['customer']<>''){
            $jos.= " and jo.id='-1'";
        }
        if(isset($_GET['item_type']) && $_GET['item_type']<>''){
            $jos.= " and IF(p.is_misc=1, 'Miscellaneous', c.name)='".$_GET['item_type']."'";
        }

        $qry.= " order by jo.date_needed, customer_name,jo_number";
        $jo = DB::select($jos);
        //dd($rs);
        //return $jos;
        $results = collect($jo)->merge(collect($rs));
        //dd($jo);
        //collect($jo)->where('jo_category','=','Order')->where('is_misc','0')->where('production_item','1')->sum('qty')  + collect($rs)->where('is_misc','0')->where('production_item','1')->sum('qty')
        //dd(collect($jo)->where('jo_category','=','Order')->sum('qty')  + collect($rs)->where('is_misc','0')->sum('qty'));
        return view('admin.reports.forecaster',compact('rs','jo','results'));

    }

    public function sales_payment(Request $request)
    {
        $qry = "SELECT h.*,h.created_at as hcreated,h.id as hid,p.*, h.order_number as hnum
        from ecommerce_sales_payments p
        left join ecommerce_sales_headers h on h.id=p.sales_header_id
        where p.id>0";

        if(isset($_GET['status']) && $_GET['status']<>''){
            $qry.= " and p.status='".$_GET['status']."'";
        }
        if(isset($_GET['customer']) && $_GET['customer']<>''){
            $qry.= " and h.customer_name='".$_GET['customer']."'";
        }
        if(isset($_GET['payment_type']) && $_GET['payment_type']<>''){
            $qry.= " and p.payment_type='".$_GET['payment_type']."'";
        }
        if(isset($_GET['startdate']) && strlen($_GET['startdate'])>=1){
            $qry.= " and p.payment_date >='".date('Y-m-d',strtotime($_GET['startdate']))." 00:00:00.000' and p.payment_date <='".date('Y-m-d',strtotime($_GET['enddate']))." 23:59:59.999'";
        }
        else{
            $qry.= " and p.payment_date >='2050-01-01 00:00:00.000'";
        }

        // if(isset($_GET['start_date']) && $_GET['start_date']<>''){
        //     $qry.= " and p.payment_date>='".date('Y-m-d',strtotime($_GET['start_date']))."'";
        // }
        // if(isset($_GET['end_date']) && $_GET['end_date']<>''){
        //     $qry.= " and p.payment_date<='".date('Y-m-d',strtotime($_GET['end_date']))."'";
        // }

        $rs = DB::select($qry);

        return view('admin.reports.sales_payment',compact('rs'));

    }
    public function delivery_report($id)
    {
        $sales = SalesHeader::whereId($id)->first();
        $salesPayments = \App\EcommerceModel\SalesPayment::where('sales_header_id',$id)->get();
        $salesDetails = \App\EcommerceModel\SalesDetail::where('sales_header_id',$id)->get();
        $totalPayment = \App\EcommerceModel\SalesPayment::where('sales_header_id',$id)->sum('amount');
        $deliveries = \App\EcommerceModel\DeliveryStatus::where('order_id',$id)->get();
        $totalNet = \App\EcommerceModel\SalesHeader::where('id',$id)->sum('net_amount');
        if($totalNet <= $totalPayment)
        $status = 'PAID';
        else $status = 'UNPAID';

       // return view('theme.'.env('FRONTEND_TEMPLATE').'.pages.ecommerce.sales_summary',compact('sales','salesPayments','salesDetails','status','deliveries'));

        return view('admin.sales.delivery_receipt',compact('sales','salesPayments','salesDetails','status','deliveries'));

    }
    public function delivery_status(Request $request)
    {
        $rs = '';
        $qry = "SELECT pb.name as prod_branch,jo.jo_number as jnum,h.*,d.*,h.created_at as hcreated,h.id as hid,p.category_id,c.name as catname,d.id as did
            FROM `ecommerce_sales_details` d
            left join ecommerce_sales_headers h on h.id=d.sales_header_id
            left join products p on p.id=d.product_id
            left join product_categories c on c.id=p.category_id
            left join job_orders jo on jo.sales_detail_id = d.id
            left join production_orders po on po.joborder_id = jo.id
            left join production_branches pb on pb.id = po.branch_id
         where h.id>0 and h.deleted_at is null";
        // conditions
            if(isset($_GET['agent']) && $_GET['agent']<>''){
                $qry.= " and h.agent='".$_GET['agent']."'";
            }
            if(isset($_GET['customer']) && $_GET['customer']<>''){
                $qry.= " and h.customer_name='".$_GET['customer']."'";
            }
            if(isset($_GET['product']) && $_GET['product']<>''){
                $qry.= " and d.product_name='".$_GET['product']."'";
            }
            if(isset($_GET['category']) && $_GET['category']<>''){
                $qry.= " and p.category_id='".$_GET['category']."'";
            }
            if(isset($_GET['order_source']) && $_GET['order_source']<>''){
                $qry.= " and h.order_source='".$_GET['order_source']."'";
            }


            if(isset($_GET['startdate']) && strlen($_GET['startdate'])>=1){
                $qry.= " and h.created_at >='".date('Y-m-d',strtotime($_GET['startdate']))."' and h.created_at <='".date('Y-m-d',strtotime($_GET['enddate']))."'";
            }
            else{
                $qry.= " and h.created_at >='".date('Y-m-d 00:00:00')."' and h.created_at <='".date('Y-m-d 23:59:59')."'";
            }
        // end conditions

        $rs = DB::select($qry);

        return view('admin.reports.delivery_status',compact('rs'));

    }

    public function leftover()
    {
        $qry =  "SELECT d.*,p.name as pname, c.name as cname, b.name as bname
                    FROM `leftovers` d
                    left join products p on p.id=d.product_id
                    left join product_categories c on c.id=p.category_id
                    left join branches b on b.id=d.branch_id
                    where d.id>0
                     ";

        if(isset($_GET['branch']) && strlen($_GET['branch'])>=1){
            $qry.= " and b.id='".$_GET['branch']."'";
        }
        if(isset($_GET['product']) && strlen($_GET['product'])>=1){
            $qry.= " and p.name like '%".$_GET['product']."%'";
        }
        if(isset($_GET['category']) && strlen($_GET['category'])>=1){
            $qry.= " and c.id='".$_GET['category']."'";
        }
        if(isset($_GET['datestart']) && strlen($_GET['datestart'])>=1){
            $qry.= " and d.date>='".date('Y-m-d',strtotime($_GET['datestart']))." 00:00:00.000' and d.date<='".date('Y-m-d',strtotime($_GET['dateend']))." 23:59:59.999'";
        }
        else{
            $qry.= " and d.date='".date('Y-m-d')."'";
        }


        $rs = DB::select($qry);

        //Dropdowns
        $branches = Branch::all();
        $products = Product::all();
        $categories = ProductCategory::all();
        return view('admin.reports.leftover',compact('rs','branches','products','categories'));

    }

/*
    public function joborder(Request $request)
    {

        $qry = "SELECT po.schedule_type as schedtype,pb.name as prod_branch,jo.jo_number as jnum,h.*,d.*,h.created_at as hcreated,h.id as hid,p.category_id,c.name as catname,d.id as did, h.instruction, h.payment_status, h.order_number as ordnum
            FROM  `ecommerce_sales_details` d
            left join ecommerce_sales_headers h on h.id=d.sales_header_id
            left join products p on p.id=d.product_id
            left join product_categories c on c.id=p.category_id
            left join job_orders jo on jo.sales_detail_id = d.id
            left join production_orders po on po.joborder_id = jo.id
            left join production_branches pb on pb.id = po.branch_id
         where h.id>0 and h.deleted_at is null";
        // conditions
            if(isset($_GET['agent']) && $_GET['agent']<>''){
                $qry.= " and h.agent='".$_GET['agent']."'";
            }
            if(isset($_GET['customer']) && $_GET['customer']<>''){
                $qry.= " and h.customer_name='".$_GET['customer']."'";
            }
            if(isset($_GET['product']) && $_GET['product']<>''){
                $qry.= " and d.product_name='".$_GET['product']."'";
            }
            if(isset($_GET['category']) && $_GET['category']<>''){
                $qry.= " and p.category_id='".$_GET['category']."'";
            }
            if(isset($_GET['order_source']) && $_GET['order_source']<>''){
                $qry.= " and h.order_source='".$_GET['order_source']."'";
            }

            if(isset($_GET['branch']) && $_GET['branch']<>''){
                $qry.= " and (h.order_source='".$_GET['branch']."' OR h.outlet='".$_GET['branch']."')";
            }
            if(isset($_GET['production_branch']) && $_GET['production_branch']<>''){
                $qry.= " and pb.id='".$_GET['production_branch']."'";
            }


            if(isset($_GET['startdate']) && strlen($_GET['startdate'])>=1){
                $qry.= " and jo.date_needed >='".date('Y-m-d',strtotime($_GET['startdate']))." 00:00:00.000' and jo.date_needed <='".date('Y-m-d',strtotime($_GET['enddate']))." 23:59:59.999'";
            }
        // end conditions
  
        $rs = DB::select($qry);


        return view('admin.reports.joborder',compact('rs'));

    }
*/
    public function joborder(Request $request)
    {

        $qry = "SELECT po.schedule_type as schedtype,pb.name as prod_branch,jo.jo_number as jnum,h.*,d.*,h.created_at as hcreated,h.id as hid,p.category_id,c.name as catname,d.id as did, h.instruction, h.payment_status, h.order_number as ordnum, jo.jo_order_type,
            IFNULL(jo.jo_category,'Miscellaneous') as item_type
            FROM  
            job_orders jo 
            left join ecommerce_sales_details d on d.id=jo.sales_detail_id
            left join ecommerce_sales_headers h on h.id=d.sales_header_id
            left join products p on p.id=d.product_id
            left join product_categories c on c.id=p.category_id
            left join production_orders po on po.joborder_id = jo.id
            left join production_branches pb on pb.id = po.branch_id
         where h.id>0 and h.deleted_at is null  and jo.deleted_at is null and po.deleted_at is null";
        // conditions
            if(isset($_GET['agent']) && $_GET['agent']<>''){
                $qry.= " and h.agent='".$_GET['agent']."'";
            }
            if(isset($_GET['customer']) && $_GET['customer']<>''){
                $qry.= " and h.customer_name='".$_GET['customer']."'";
            }
            if(isset($_GET['product']) && $_GET['product']<>''){
                $qry.= " and d.product_name='".$_GET['product']."'";
            }
            if(isset($_GET['category']) && $_GET['category']<>''){
                $qry.= " and p.category_id='".$_GET['category']."'";
            }
            if(isset($_GET['order_source']) && $_GET['order_source']<>''){
                $qry.= " and h.order_source='".$_GET['order_source']."'";
            }

            if(isset($_GET['branch']) && $_GET['branch']<>''){
                $qry.= " and (h.order_source='".$_GET['branch']."' OR h.outlet='".$_GET['branch']."')";
            }
            if(isset($_GET['production_branch']) && $_GET['production_branch']<>''){
                $qry.= " and pb.id='".$_GET['production_branch']."'";
            }


            if(isset($_GET['startdate']) && strlen($_GET['startdate'])>=1){
                $qry.= " and jo.date_needed >='".date('Y-m-d',strtotime($_GET['startdate']))." 00:00:00.000' and jo.date_needed <='".date('Y-m-d',strtotime($_GET['enddate']))." 23:59:59.999'";
            }
            else{
                $qry.= " and jo.date_needed >='2050-01-01 00:00:00.000' and jo.date_needed <='2050-01-01 23:59:59.999'";
            }
            if(isset($_GET['item_type']) && $_GET['item_type']<>''){
                $qry.= " and IFNULL(jo.jo_category,'Miscellaneous')='".$_GET['item_type']."'";
            }
        // end conditions
  
        $rs = DB::select($qry);

        return view('admin.reports.joborder',compact('rs'));

    }

    public function door2door_report(Request $request)
    {

        $qry = "SELECT po.schedule_type as schedtype,pb.name as prod_branch,jo.jo_number as jnum,h.*,d.*,h.created_at as hcreated,h.id as hid,p.category_id,c.name as catname,d.id as did, h.instruction, h.payment_status, h.order_number as ordnum
            FROM  `ecommerce_sales_details` d
            left join ecommerce_sales_headers h on h.id=d.sales_header_id
            left join products p on p.id=d.product_id
            left join product_categories c on c.id=p.category_id
            left join job_orders jo on jo.sales_detail_id = d.id
            left join production_orders po on po.joborder_id = jo.id
            left join production_branches pb on pb.id = po.branch_id
         where h.delivery_type='Door to door delivery' and h.deleted_at is null and h.isConfirm=1";

         // $qry = "SELECT po.schedule_type as schedtype,pb.name as prod_branch,j.jo_number as jnum,h.*,d.*,h.created_at as hcreated,h.id as hid,p.category_id,c.name as catname,d.id as did, h.instruction, h.payment_status, h.order_number as ordnum
         //        FROM `production_orders` po
         //            left join production_branches pb on pb.id=p.branch_id
         //            left join job_orders j on j.id=p.joborder_id
         //            left join ecommerce_sales_details d on d.id=j.sales_detail_id
         //            left join ecommerce_sales_headers h on h.id=d.sales_header_id
         //            left join products p on p.id=d.product_id
         //            left join product_categories c on c.id=p.category_id
         //            where j.id>0";
        // conditions
            if(isset($_GET['agent']) && $_GET['agent']<>''){
                $qry.= " and h.agent='".$_GET['agent']."'";
            }
            if(isset($_GET['customer']) && $_GET['customer']<>''){
                $qry.= " and h.customer_name='".$_GET['customer']."'";
            }
            if(isset($_GET['product']) && $_GET['product']<>''){
                $qry.= " and d.product_name='".$_GET['product']."'";
            }
            if(isset($_GET['category']) && $_GET['category']<>''){
                $qry.= " and p.category_id='".$_GET['category']."'";
            }
            if(isset($_GET['order_source']) && $_GET['order_source']<>''){
                $qry.= " and h.order_source='".$_GET['order_source']."'";
            }

            if(isset($_GET['branch']) && $_GET['branch']<>''){
                $qry.= " and (h.order_source='".$_GET['branch']."' OR h.outlet='".$_GET['branch']."')";
            }


            if(isset($_GET['startdate']) && strlen($_GET['startdate'])>=1){
                $qry.= " and d.delivery_date >='".date('Y-m-d',strtotime($_GET['startdate']))." 00:00:00.000' and d.delivery_date <='".date('Y-m-d',strtotime($_GET['enddate']))." 23:59:59.999'";
            }
            else{
                $qry.= " and d.delivery_date >='2051-01-01 00:00:00.000' and d.delivery_date <='2051-01-01 23:59:59.999'";
            }
        // end conditions

        $rs = DB::select($qry);


        return view('admin.reports.door2door',compact('rs'));

    }

    public function productionorders(Request $request)
    {
        $qry =  "SELECT p.*,pb.name as production_name, j.jo_number as jo_number,h.instruction as remarks
                    FROM `production_orders` p
                    left join production_branches pb on pb.id=p.branch_id
                    left join job_orders j on j.id=p.joborder_id
                    left join ecommerce_sales_headers h on h.order_number=j.sales_number
                    where j.id>0  and h.deleted_at is null";

        if(isset($_GET['startdate']) && strlen($_GET['startdate'])>=1){
            $qry.= " and p.delivery_date>='".date('Y-m-d',strtotime($_GET['startdate']))." 00:00:00.000' and p.delivery_date<='".date('Y-m-d',strtotime($_GET['enddate']))." 23:59:59.999'";
        }
        else{
            $qry.= " and p.delivery_date>='2051-01-01 00:00:00.000' and p.delivery_date<='2051-01-01 23:59:59.999'";
        }

        if(isset($_GET['branch']) && strlen($_GET['branch'])>=1){
            $qry.= " and p.branch_id='".$_GET['branch']."'";
        }


        $rs = DB::select($qry);

        $branches = ProductionBranch::orderBy('name','asc')->get();

        return view('admin.reports.production_orders',compact('rs','branches'));

    }

    public function sales_per_agent(Request $request)
    {
       $qry = "SELECT pb.name as prod_branch,jo.jo_number as jnum,h.*,d.*,h.created_at as hcreated,h.id as hid,p.category_id,c.name as catname,d.id as did
            FROM `ecommerce_sales_details` d
            left join ecommerce_sales_headers h on h.id=d.sales_header_id
            left join products p on p.id=d.product_id
            left join product_categories c on c.id=p.category_id
            left join job_orders jo on jo.sales_detail_id = d.id
            left join production_orders po on po.joborder_id = jo.id
            left join production_branches pb on pb.id = po.branch_id
         where h.id>0 and h.agent is not null and h.deleted_at is null";
        // conditions

            if(isset($_GET['agent']) && $_GET['agent']<>''){
                if($_GET['agent']=='no-agent')
                    $qry.= " and (h.agent='' OR h.agent is null)";
                else
                    $qry.= " and h.agent='".$_GET['agent']."'";
            }


            if(isset($_GET['startdate']) && strlen($_GET['startdate'])>=1){
                $qry.= " and h.created_at >='".date('Y-m-d',strtotime($_GET['startdate']))." 00:00:00.000' and h.created_at <='".date('Y-m-d',strtotime($_GET['enddate']))." 23:59:59.999'";
            }
        // end conditions

        $rs = DB::select($qry);

        $agents = SalesHeader::distinct()->where('agent','<>','')->orderBy('agent')->get(['agent']);

        return view('admin.reports.sales_per_agent',compact('rs','agents'));
    }

    public function sales_per_customer(Request $request)
    {

        $qry = "SELECT pb.name as prod_branch,jo.jo_number as jnum,h.*,d.*,h.created_at as hcreated,h.id as hid,p.category_id,c.name as catname,d.id as did
            FROM `ecommerce_sales_details` d
            left join ecommerce_sales_headers h on h.id=d.sales_header_id
            left join products p on p.id=d.product_id
            left join product_categories c on c.id=p.category_id
            left join job_orders jo on jo.sales_detail_id = d.id
            left join production_orders po on po.joborder_id = jo.id
            left join production_branches pb on pb.id = po.branch_id
         where h.id>0 and h.deleted_at is null";
        // conditions

            if(isset($_GET['customer']) && $_GET['customer']<>''){
                $qry.= " and h.customer_name='".$_GET['customer']."'";
            }


            if(isset($_GET['startdate']) && strlen($_GET['startdate'])>=1){
                $qry.= " and h.created_at >='".date('Y-m-d',strtotime($_GET['startdate']))." 00:00:00.000' and h.created_at <='".date('Y-m-d',strtotime($_GET['enddate']))." 23:59:59.999'";
            }
        // end conditions

        $rs = DB::select($qry);

        $customers = SalesHeader::distinct()->orderBy('customer_name')->get(['customer_name']);

        return view('admin.reports.sales_per_customer',compact('rs','customers'));
    }

    public function forecast(Request $request)
    {
        $qry = "SELECT po.*,jo.*,h.instruction as remarks
                FROM `job_orders` jo
                left join production_orders po on po.joborder_id=jo.id
                left join ecommerce_sales_headers h on h.order_number=jo.sales_number
                where jo.status = 'Active'  and h.deleted_at is null";

        if(isset($_GET['branch']) && strlen($_GET['branch'])>=1){
            $qry.= " and po.branch_id='".$_GET['branch']."'";
        }



        if(isset($_GET['startdate']) && strlen($_GET['startdate'])>=1){
            $qry.= " and po.delivery_date >='".date('Y-m-d',strtotime($_GET['startdate']))." 00:00:00.000' and po.delivery_date <='".date('Y-m-d',strtotime($_GET['enddate']))." 23:59:59.999'";
        }

        $rs = DB::select($qry);

        $branches = Branch::orderBy('name','asc')->get();

        return view('admin.reports.forecast',compact('rs','branches'));
    }

    public function payment(Request $request)
    {
        $qry = "SELECT po.*,jo.*,h.instruction as remarks
                FROM `job_orders` jo
                left join production_orders po on po.joborder_id=jo.id
                left join ecommerce_sales_headers h on h.order_number=jo.sales_number
                where jo.status = 'Active'  and h.deleted_at is null";

        if(isset($_GET['branch']) && strlen($_GET['branch'])>=1){
            $qry.= " and po.branch_id='".$_GET['branch']."'";
        }

        if(isset($_GET['startdate']) && strlen($_GET['startdate'])>=1){
            $qry.= " and po.delivery_date >='".date('Y-m-d',strtotime($_GET['startdate']))." 00:00:00.000' and po.delivery_date <='".date('Y-m-d',strtotime($_GET['enddate']))." 23:59:59.999'";
        }

        $rs = DB::select($qry);

        $branches = Branch::orderBy('name','asc')->get();

        return view('admin.reports.forecast',compact('rs','branches'));
    }
    
    
    // new reports added by ryan 08/05/2021
    public function sales_social(Request $request)
    {
        $qry = "select origin, count(id) total_order,sum(gross_amount) total_revenue from ecommerce_sales_headers where status = 'active' and payment_status = 'PAID' ";

        if(isset($_GET['startdate']) && strlen($_GET['startdate'])>=1){
            $startDate = date('Y-m-d',strtotime($_GET['startdate']));
            $endDate = date('Y-m-d',strtotime($_GET['enddate']));

            $qry.= " and created_at >='".$startDate." 00:00:00.000' and created_at <='".$endDate." 23:59:59.999'";
        } else {
            $firstDayOfMonth = new Carbon('first day of this month');

            $startDate = $firstDayOfMonth->format('Y-m-d');
            $endDate   = Carbon::today()->format('Y-m-d');

            $qry.= " and created_at >='".$startDate." 00:00:00.000' and created_at <='".$endDate." 23:59:59.999'";
        }

        $qry .= " group by origin";
        $rs = DB::select($qry);

        return view('admin.reports.sales_per_social_media',compact('rs','startDate','endDate'));
    }

    public function top_agents(Request $request)
    {
        $qry = "select agent, count(id) as total_orders from ecommerce_sales_headers where agent is not null and status = 'active' and payment_status = 'PAID' ";

        if(isset($_GET['startdate']) && strlen($_GET['startdate'])>=1){
            $startDate = date('Y-m-d',strtotime($_GET['startdate']));
            $endDate = date('Y-m-d',strtotime($_GET['enddate']));

            $qry.= " and created_at >='".$startDate." 00:00:00.000' and created_at <='".$endDate." 23:59:59.999'";
        } else {
            $firstDayOfMonth = new Carbon('first day of this month');

            $startDate = $firstDayOfMonth->format('Y-m-d');
            $endDate   = Carbon::today()->format('Y-m-d');

            $qry.= " and created_at >='".$startDate." 00:00:00.000' and created_at <='".$endDate." 23:59:59.999'";
        }

        $qry .= " group by agent";
        $rs = DB::select($qry);

        return view('admin.reports.sales_top_agent',compact('rs','startDate','endDate'));
    }
    
    public function guest_orders(Request $request)
    {
        $qry = "select * from users where user_type = 'customer' and email like '%lydias.com%' ";


        if(isset($_GET['startdate']) && strlen($_GET['startdate'])>=1){
            $startDate = date('Y-m-d',strtotime($_GET['startdate']));
            $endDate = date('Y-m-d',strtotime($_GET['enddate']));

            $qry.= " and created_at >='".$startDate." 00:00:00.000' and created_at <='".$endDate." 23:59:59.999'";
        } else {
            $firstDayOfMonth = new Carbon('first day of this month');

            $startDate = $firstDayOfMonth->format('Y-m-d');
            $endDate   = Carbon::today()->format('Y-m-d');

            $qry.= " and created_at >='".$startDate." 00:00:00.000' and created_at <='".$endDate." 23:59:59.999'";
        }
        $rs = DB::select($qry);

        return view('admin.reports.sales_guest_logins',compact('rs','startDate','endDate'));
    }

    public function top_products(Request $request)
    {
        $qry = "select sd.product_name, count(sh.id) total_orders, sum(sd.price*sd.qty) total_sales, sum(sd.qty) total_volume, p.weight from ecommerce_sales_details sd left join ecommerce_sales_headers sh on sh.id = sd.sales_header_id left join products as p on p.id = sd.product_id where sh.status = 'active' and sh.payment_status = 'PAID' ";

        if(isset($_GET['startdate']) && strlen($_GET['startdate'])>=1){
            $startDate = date('Y-m-d',strtotime($_GET['startdate']));
            $endDate = date('Y-m-d',strtotime($_GET['enddate']));

            $qry.= " and sh.created_at >='".$startDate." 00:00:00.000' and sh.created_at <='".$endDate." 23:59:59.999'";
        } else {
            $firstDayOfMonth = new Carbon('first day of this month');

            $startDate = $firstDayOfMonth->format('Y-m-d');
            $endDate   = Carbon::today()->format('Y-m-d');

            $qry.= " and sh. created_at >='".$startDate." 00:00:00.000' and sh.created_at <='".$endDate." 23:59:59.999'";
        }

        $qry .= " group by sd.product_id order by total_sales desc ";
        $rs = DB::select($qry);

        return view('admin.reports.sales_top_products',compact('rs','startDate','endDate'));
    }

    public function sales_per_branch(Request $request)
    {
        $qry = "select order_source, count(id) total_order,sum(gross_amount) total_revenue from ecommerce_sales_headers where status = 'active' and payment_status = 'PAID' ";

        if(isset($_GET['startdate']) && strlen($_GET['startdate'])>=1){
            $startDate = date('Y-m-d',strtotime($_GET['startdate']));
            $endDate = date('Y-m-d',strtotime($_GET['enddate']));

            $qry.= " and created_at >='".$startDate." 00:00:00.000' and created_at <='".$endDate." 23:59:59.999'";
        } else {
            $firstDayOfMonth = new Carbon('first day of this month');

            $startDate = $firstDayOfMonth->format('Y-m-d');
            $endDate   = Carbon::today()->format('Y-m-d');

            $qry.= " and created_at >='".$startDate." 00:00:00.000' and created_at <='".$endDate." 23:59:59.999'";
        }

        $qry .= " group by order_source";
        $rs = DB::select($qry);

        return view('admin.reports.sales_per_branch',compact('rs','startDate','endDate'));
    }
    
    public function sales_category(Request $request)
    {
        $qry = "select sd.product_category, pcat.name, sum(sd.price*sd.qty) total_sales, count(sh.id) total_orders, sum(sd.qty) total_volume from ecommerce_sales_details sd left join ecommerce_sales_headers sh on sh.id = sd.sales_header_id left join product_categories as pcat on pcat.id = sd.product_category where sh.status = 'active' and sh.payment_status = 'PAID' ";

        if(isset($_GET['startdate']) && strlen($_GET['startdate'])>=1){
            $startDate = date('Y-m-d',strtotime($_GET['startdate']));
            $endDate = date('Y-m-d',strtotime($_GET['enddate']));

            $qry.= " and sh.created_at >='".$startDate." 00:00:00.000' and sh.created_at <='".$endDate." 23:59:59.999'";
        } else {
            $firstDayOfMonth = new Carbon('first day of this month');

            $startDate = $firstDayOfMonth->format('Y-m-d');
            $endDate   = Carbon::today()->format('Y-m-d');

            $qry.= " and sh. created_at >='".$startDate." 00:00:00.000' and sh.created_at <='".$endDate." 23:59:59.999'";
        }

        $qry .= " group by sd.product_category";
        $rs = DB::select($qry);

        return view('admin.reports.sales_per_category',compact('rs','startDate','endDate'));
    }
    
    
    public function dispatcher(Request $request)
    {
        /*SELECT h.*,d.*,po.delivery_date as hcreated,h.id as hid,p.category_id,c.name as catname,h.agent,pb.name as pbname, h.delivery_status as delstat,
        po.delivery_date as deldate, h.delivery_type,h.instruction, jo.jo_number,br.name as receiver,p.is_misc,u.name as username, jo.jo_order_type, u.address_street, u.address_municipality, u.address_city, u.address_region, IF(p.is_misc=1, 'Miscellaneous', c.name) as item_type,p.is_misc,p.production_item,*/

        $qry = "SELECT d.product_name, d.paella_price,
        d.qty, h.order_number, u.address_street, u.address_municipality, u.address_city, u.address_region,d.price, h.customer_delivery_adress,
        h.customer_name, d.delivery_date as delivery_date, h.instruction, po.delivery_date as deldate, h.delivery_type, jo.jo_number, pb.name as pbname, h.delivery_status as delstat,h.agent, h.customer_contact_number,'' as dr, h.delivery_fee_amount, d.price, '' as releasing, h.order_source, br.name as receiver, c.name as catname, u.name as username, jo.jo_order_type, IF(p.is_misc=1, 'Miscellaneous', c.name) as item_type, h.id as hid, '' as jo_category, 'sales' as trantype, DATE_FORMAT(d.delivery_date,'%H:%i:%s') as timeneeded, DATE_FORMAT(d.delivery_date, '%Y-%m-%d') as dateneeded, p.is_misc, p.production_item
        FROM `ecommerce_sales_details` d
        left join ecommerce_sales_headers h on h.id=d.sales_header_id
        left join products p on p.id=d.product_id
        left join product_categories c on c.id=p.category_id
        left join job_orders jo on jo.sales_detail_id = d.id
        left join branches br on  br.id = jo.pickup_branch
        left join production_orders po on po.joborder_id = jo.id
        left join production_branches pb on pb.id = po.branch_id
        left join users u on u.id = d.created_by
        where h.id>0 and h.deleted_at is null and jo.deleted_at is null and po.deleted_at is null";

        if(isset($_GET['agent']) && $_GET['agent']<>''){
            $qry.= " and h.agent='".$_GET['agent']."'";
        }
        if(isset($_GET['customer']) && $_GET['customer']<>''){
            $qry.= " and h.customer_name='".$_GET['customer']."'";
        }
        if(isset($_GET['product']) && $_GET['product']<>''){
            $qry.= " and d.product_name='".$_GET['product']."'";
        }
        if(isset($_GET['category']) && $_GET['category']<>''){
            $qry.= " and p.category_id='".$_GET['category']."'";
        }
        if(isset($_GET['order_source']) && $_GET['order_source']<>''){
            $qry.= " and h.order_source='".$_GET['order_source']."'";
        }
        if(isset($_GET['production_branch']) && $_GET['production_branch']<>''){
            $qry.= " and pb.id='".$_GET['production_branch']."'";
        }
        if(isset($_GET['receiver']) && $_GET['receiver']<>''){
            $br = \App\EcommerceModel\Branch::whereId($_GET['receiver'])->first();
            $qry.= " and ((h.delivery_type='Store Pickup' and h.customer_delivery_adress='".$br->name."') or jo.pickup_branch='".$_GET['receiver']."')";
        }


        if(isset($_GET['startdate']) && strlen($_GET['startdate'])>=1){
            $qry.= " and po.delivery_date >='".date('Y-m-d',strtotime($_GET['startdate']))." 00:00:00.000' and po.delivery_date <='".date('Y-m-d',strtotime($_GET['enddate']))." 23:59:59.999'";
        }
        else{
            $qry.= " and po.delivery_date >='2051-01-01 00:00:00.000' and po.delivery_date <='2051-01-01 23:59:59.999'";
        }
        if(isset($_GET['start_time']) && $_GET['start_time']<>''){ 
            $qry.= " and time(d.delivery_date)='".$_GET['start_time']."'";
        }
        if(isset($_GET['item_type']) && $_GET['item_type']<>''){
            $qry.= " and IF(p.is_misc=1, 'Miscellaneous', c.name)='".$_GET['item_type']."'";
        }
        //return $qry;
        $qry.= " order by d.delivery_date,customer_name,order_number";
        $rs = DB::select($qry);
        //dd($rs);
        // Pantaga created by forecaster
        // SELECT jo.*,p.category_id,c.name as catname,pb.name as pbname, p.name as product_name,po.delivery_date as deldate,br.name as receiver,jo.remarks as joremarks,u.name as username, jo.jo_order_type, u.address_street, u.address_municipality, u.address_city, u.address_region,
        //     IF(p.is_misc=1, 'Miscellaneous', c.name) as item_type,p.is_misc,p.production_item from job_orders jo 

        $jos = "
            SELECT jo.jo_category as product_name, '' as paella_price,
        jo.qty as qty, '' as order_number, u.address_street, u.address_municipality, u.address_city, u.address_region, jo.price, jo.customer_address as customer_delivery_adress,
        jo.customer_name, jo.date_needed as delivery_date,jo.remarks as instruction, po.delivery_date as deldate,'' as delivery_type, jo.jo_number, pb.name as pbname, '' as delstat, '' as agent, '' as customer_contact_number,'' as dr, '0' as delivery_fee_amount,'0' as price, '' as releasing, 'Forecaster' as order_source, br.name as receiver, c.name as catname, u.name as username, jo.jo_order_type, IF(p.is_misc=1, 'Miscellaneous', c.name) as item_type, '0' as hid, jo.jo_category as jo_category, 'jo' as trantype, DATE_FORMAT(jo.date_needed,'%H:%i:%s') as timeneeded, DATE_FORMAT(jo.date_needed, '%Y-%m-%d') as dateneeded, p.is_misc, p.production_item from job_orders jo 
        left join branches br on  br.id = jo.pickup_branch
        left join production_orders po on po.joborder_id = jo.id
        left join production_branches pb on pb.id = po.branch_id
        left join products p on p.id=jo.product_id
        left join product_categories c on c.id=p.category_id
        left join users u on u.id = jo.user_id
        where jo.id>0 and jo.deleted_at is null and po.deleted_at is null and (jo.sales_detail_id=0 or jo.sales_detail_id is null)";

        if(isset($_GET['product']) && $_GET['product']<>''){
            $jos.= " and p.name='".$_GET['product']."'";
        }
        if(isset($_GET['category']) && $_GET['category']<>''){
            $jos.= " and p.category_id='".$_GET['category']."'";
        }        
        if(isset($_GET['production_branch']) && $_GET['production_branch']<>''){
            $jos.= " and pb.id='".$_GET['production_branch']."'";
        }
        if(isset($_GET['startdate']) && strlen($_GET['startdate'])>=1){
            $jos.= " and po.delivery_date >='".date('Y-m-d',strtotime($_GET['startdate']))." 00:00:00.000' and po.delivery_date <='".date('Y-m-d',strtotime($_GET['enddate']))." 23:59:59.999'";
        }
        else{
            $jos.= " and po.delivery_date >='2051-01-01 00:00:00.000' and po.delivery_date <='2051-01-01 23:59:59.999'";
        }
        if(isset($_GET['start_time']) && $_GET['start_time']<>''){
            $jos.= " and time(po.delivery_date)='".$_GET['start_time']."'";
        }
        if(isset($_GET['receiver']) && $_GET['receiver']<>''){
            $jos.= " and jo.pickup_branch='".$_GET['receiver']."'";
        }

        if(isset($_GET['customer']) && $_GET['customer']<>''){
            $jos.= " and jo.id='-1'";
        }
        if(isset($_GET['item_type']) && $_GET['item_type']<>''){
            $jos.= " and IF(p.is_misc=1, 'Miscellaneous', c.name)='".$_GET['item_type']."'";
        }

        $jos.= " order by jo.date_needed, customer_name,jo_number";
        $jo = DB::select($jos);

        //dd($rs);
        //return $jos;
        $results = collect($jo)->merge($rs)->groupBy('customer_name');

        $rs = $results->paginate(20);
 
        //dd($jo);
        //collect($jo)->where('jo_category','=','Order')->where('is_misc','0')->where('production_item','1')->sum('qty')  + collect($rs)->where('is_misc','0')->where('production_item','1')->sum('qty')
        //dd(collect($jo)->where('jo_category','=','Order')->sum('qty')  + collect($rs)->where('is_misc','0')->sum('qty'));
        return view('admin.reports.dispatcher',compact('rs','jo','results'));

    }

}
