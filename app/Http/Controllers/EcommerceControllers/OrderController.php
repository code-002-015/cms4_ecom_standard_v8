<?php

namespace App\Http\Controllers\EcommerceControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\ListingHelper;
use App\EcommerceModel\SalesHeader;
use Auth;

class OrderController extends Controller
{
    private $searchFields = ['order_number','customer_name'];
    public function index()
    {
        $listing = new ListingHelper('desc',10,'order_number');
        $orders = $listing->simple_search(SalesHeader::status(), $this->searchFields);
        $filter = $listing->get_filter($this->searchFields);
        $searchType = 'simple_search';

//        $orders = SalesHeader::where('status', 'PAID')->get();

        return view('admin.forecaster.orders.index', compact('orders','filter','searchType'));
    }
}
