<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use \App\Models\SalesDetail;
use \App\Models\SalesHeader;
use \App\Models\Product;
use \App\Models\ActivityLog;

use Carbon\CarbonPeriod;
use Carbon\Carbon;
use DateTime;
use Auth;
use DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
    	if(Auth::user()->role_id == '6'){
    		Auth::logout();
    		return back()->with('error','Restricted access');
    	}

    	$logs = ActivityLog::where('log_by', auth()->id())->orderBy('id','desc')->paginate(15);

        return view('admin.dashboard.index',compact('logs'));
    }

    public function ecommerce(Request $request)
    {
        if(isset($_GET['data_from'])){
            if($_GET['data_from'] == 'today'){
                $startDate = Carbon::today()->format('Y-m-d');
                $endDate   = Carbon::today()->format('Y-m-d');
            }

            if($_GET['data_from'] == 'last_30_days'){
                $startDate = Carbon::now()->subDays(30)->format('Y-m-d');
                $endDate   = Carbon::today()->format('Y-m-d');
            }

            if($_GET['data_from'] == 'last_month'){
                $firstDayLastMonth = new Carbon('first day of last month');
                $lastDayLastMonth  = new Carbon('last day of last month');

                $startDate = $firstDayLastMonth->format('Y-m-d');
                $endDate   = $lastDayLastMonth->format('Y-m-d');
            }

            if($_GET['data_from'] == 'month_to_date'){
                $firstDayOfMonth = new Carbon('first day of this month');

                $startDate = $firstDayOfMonth->format('Y-m-d');
                $endDate   = Carbon::today()->format('Y-m-d');
            }

            if($_GET['data_from'] == 'custom_date'){
                $firstDayOfMonth = new Carbon('first day of this month');

                $startDate = $_GET['startdate'];
                $endDate   = $_GET['enddate'];
            }

        } else {
            $firstDayOfMonth = new Carbon('first day of this month');

            $startDate = $firstDayOfMonth->format('Y-m-d');
            $endDate   = Carbon::today()->format('Y-m-d');
        }


        $qry_product =  "select d.product_id, d.product_name, count(h.id) total_order, sum(d.price*d.qty) total_revenue, sum(d.qty) total_volume from ecommerce_sales_details d left join ecommerce_sales_headers h on h.id = d.sales_header_id left join products p on p.id = d.product_id where h.status = 'active' and h.payment_status = 'PAID' and h.created_at >='".date('Y-m-d',strtotime($startDate))." 00:00:00.000' and h.created_at <='".date('Y-m-d',strtotime($endDate))." 23:59:59.999' group by d.product_id, d.product_name";


        if(isset($_GET['filter'])){
            if($_GET['filter'] == 'sales'){
                $qry_product .= " order by total_revenue desc limit 10";

                $qry_cat = "select pc.name, d.product_category, sum(d.price*d.qty) filtered_value from ecommerce_sales_details d left join ecommerce_sales_headers h on h.id = d.sales_header_id left join product_categories pc on pc.id = d.product_category where h.status = 'active' ";

                $top_soc_media = DB::select("select origin, sum(gross_amount) as filtered_value from ecommerce_sales_headers where status = 'active' and payment_status = 'PAID' and created_at >='".date('Y-m-d',strtotime($startDate))." 00:00:00.000' and created_at <='".date('Y-m-d',strtotime($endDate))." 23:59:59.999' group by origin order by filtered_value desc ");


                $pie_socmed_title = 'Sales by Social Media';
                $pie_branch_title = 'Sales by Branch';
                $pie_ctgory_title = 'Sales by Category';
            }

            if($_GET['filter'] == 'orders'){
                $qry_product .= " order by total_order desc limit 10";

                $qry_cat = "select pc.name, d.product_category, count(h.id) filtered_value from ecommerce_sales_details d left join ecommerce_sales_headers h on h.id = d.sales_header_id left join product_categories pc on pc.id = d.product_category where h.status = 'active' ";

                $top_soc_media = DB::select("select origin, count(id) as filtered_value from ecommerce_sales_headers where status = 'active' and payment_status = 'PAID' and created_at >='".date('Y-m-d',strtotime($startDate))." 00:00:00.000' and created_at <='".date('Y-m-d',strtotime($endDate))." 23:59:59.999' group by origin order by filtered_value desc ");


                $pie_socmed_title = 'Orders by Social Media';
                $pie_branch_title = 'Orders by Branch';
                $pie_ctgory_title = 'Orders by Category';
            }

            if($_GET['filter'] == 'volume'){
                $qry_product .= " order by total_volume desc limit 10";

                $qry_cat = "select pc.name, d.product_category, sum(d.qty) filtered_value from ecommerce_sales_details d left join ecommerce_sales_headers h on h.id = d.sales_header_id left join product_categories pc on pc.id = d.product_category where h.status = 'active' ";

                $top_soc_media = DB::select("select h.origin, sum(d.qty) as filtered_value from ecommerce_sales_details d left join ecommerce_sales_headers h on h.id = d.sales_header_id where h.status = 'active' and h.payment_status = 'PAID' and h.created_at >='".date('Y-m-d',strtotime($startDate))." 00:00:00.000' and h.created_at <='".date('Y-m-d',strtotime($endDate))." 23:59:59.999' group by h.origin order by filtered_value desc ");


                $pie_socmed_title = 'Order Volume by Social Media';
                $pie_branch_title = 'Order Volume by Branch';
                $pie_ctgory_title = 'Order Volume by Category';
            }
        } else {
            $qry_product .= " order by total_revenue desc limit 10";

            $qry_cat = "select pc.name, d.product_category, sum(d.price*d.qty) filtered_value from ecommerce_sales_details d left join ecommerce_sales_headers h on h.id = d.sales_header_id left join product_categories pc on pc.id = d.product_category where h.status = 'active' ";

            $top_soc_media = DB::select("select origin, sum(gross_amount) as filtered_value from ecommerce_sales_headers where status = 'active' and payment_status = 'PAID' and created_at >='".date('Y-m-d',strtotime($startDate))." 00:00:00.000' and created_at <='".date('Y-m-d',strtotime($endDate))." 23:59:59.999' group by origin order by filtered_value desc ");


            $pie_socmed_title = 'Sales by Social Media';
            $pie_branch_title = 'Sales by Branch';
            $pie_ctgory_title = 'Sales by Category';
        }

        $qry_cat .= " and h.payment_status = 'PAID' and h.created_at >='".date('Y-m-d',strtotime($startDate))." 00:00:00.000' and h.created_at <='".date('Y-m-d',strtotime($endDate))." 23:59:59.999' group by d.product_category order by filtered_value desc ";


        $top_selling_categories = DB::select($qry_cat);
        



        $top_selling_products = DB::select($qry_product);
        $top_prod_names = '';
        $top_prod_earnings = '';
        foreach($top_selling_products as $p){
            $top_prod_names .= str_replace(')',' ',$p->product_name).'|';

            if(isset($_GET['filter'])){
                if($_GET['filter'] == 'sales'){
                    $top_prod_earnings .= $p->total_revenue.'|';
                }

                if($_GET['filter'] == 'orders'){
                    $top_prod_earnings .= $p->total_order.'|';
                }

                if($_GET['filter'] == 'volume'){
                    $top_prod_earnings .= $p->total_volume.'|';
                }

            } else {
                $top_prod_earnings .= $p->total_revenue.'|';
            }
        }

        $yr = date("Y",strtotime("-3 year"));
        $arr_yrs = '';
        for ($x = 1; $x <= 3; $x++) {
            $yr++;

            ${"year$x"} = SalesHeader::monthly_sales($yr);
            $arr_yrs .= $yr.'|';
        }


        $arr_months = array();
        for ($i = 0; $i < 8; $i++) {
            $timestamp = mktime(0, 0, 0, date('n') - $i, 1);
            $arr_months[] = date('F', $timestamp);
        }

        $rmonths = array_reverse($arr_months);
        $months = '';
        foreach($rmonths as $mos){
            $months .= $mos.'|';
        }

        return view('admin.dashboard.ecom-index',compact('top_selling_products','top_selling_categories','top_soc_media','startDate','endDate','top_prod_names','top_prod_earnings','months','year1','year2','year3','arr_yrs','pie_socmed_title','pie_branch_title','pie_ctgory_title'));
    }
}
