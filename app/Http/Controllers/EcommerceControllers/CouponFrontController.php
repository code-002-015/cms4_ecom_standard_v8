<?php

namespace App\Http\Controllers\EcommerceControllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use App\Helpers\ListingHelper;

use App\Models\Coupon;
use App\Models\CustomerCoupon;
use App\Models\CouponSale;
use App\Models\CouponCart;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Page;

use Auth;

class CouponFrontController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
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
        //
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
        //
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

    public function claimed()
    {
        $page = new Page();
        $page->name = 'Claimed Coupons';

        $coupons = CouponSale::where('customer_id',Auth::id())->where('order_status','PAID')->get();

        return view('theme.sysu.pages.ecommerce.coupons-claimed',compact('page','coupons'));
    }

    public function use_coupon($coupon_id)
    {
        CouponCart::create([
            'customer_id' => Auth::id(),
            'coupon_id' => $coupon_id
        ]);

        return redirect(route('cart.front.show'))->with('success','Coupon successfully place.');
    }

    public function add_manual_coupon(Request $request)
    {   
        $coupon = Coupon::where('coupon_code',$request->couponcode)->where('activation_type','manual');
        if($coupon->exists()){
            $c = $coupon->first();

            if($c->customer_scope == 'specific'){
                $customer_id = explode('|',$c->scope_customer_id);
                $arr_customer_id = [];
                foreach($customer_id as $id){
                    array_push($arr_customer_id, $id);
                }

                if(in_array(auth()->user()->email, $arr_customer_id)){
                    return response()->json([
                        'success' => true, 
                        'coupon_details' => $c              
                    ]);
                } else {
                    return response()->json([
                        'not_allowed' => true,               
                    ]);
                }

            } else {
                $couponCart = CouponCart::where('customer_id',Auth::id())->where('coupon_id',$c->id)->exists();
                if($couponCart){
                    return response()->json([
                        'exist' => true,               
                    ]);
                } else {
                    if($c->status == 'EXPIRED' || $c->status == 'INACTIVE'){
                        return response()->json([
                            'expired' => true,               
                        ]);
                    } else {
                        
                        // CouponCart::create([
                        //     'customer_id' => Auth::id(),
                        //     'coupon_id' => $c->id
                        // ]);

                        return response()->json([
                            'success' => true, 
                            'coupon_details' => $c              
                        ]);
                    }
                }

            }
        } else {
            return response()->json([
                'not_exist' => true,               
            ]);
        }
        
    }

    public function collectibles(Request $request){
        // Total Purchase Amount Only
            $couponsMinTotalAmount = Coupon::couponPurchaseValue('purchase_amount','purchase_amount_type',$request->total_amount,'min','<=');
            $couponsMaxTotalAmount = Coupon::couponPurchaseValue('purchase_amount','purchase_amount_type',$request->total_amount,'max','>=');
        //

        //Total Purchase Quantity Only
            $couponsMinTotalQty    = Coupon::couponPurchaseValue('purchase_qty','purchase_qty_type',$request->total_qty,'min','<=');
            $couponsMaxTotalQty    = Coupon::couponPurchaseValue('purchase_qty','purchase_qty_type',$request->total_qty,'max','>=');
        //

        // Coupon All Customer Events
            $couponEvents = Coupon::where('status','ACTIVE')
                ->where('availability',1)
                ->whereNotNull('event_date')
                ->where('customer_scope','all')
                ->where('event_date',today())
                ->get();
        //

        // Coupon All Customer Events
            $couponEventSpecific = 
                Coupon::where('status','ACTIVE')
                ->where('availability',1)
                ->whereNotNull('event_date')
                ->where('customer_scope','specific')
                ->where('event_date',today())
                ->get();

            $arr_coupon_event_specific = [];
            foreach($couponEventSpecific as $c){
                $customers = explode('|',$c->scope_customer_id);
                foreach($customers as $cs){
                    if($cs == auth()->user()->email){
                        array_push($arr_coupon_event_specific, $c->id);
                    }
                }
            }

            $couponeventspecific = Coupon::whereIn('id',$arr_coupon_event_specific)->get();
        //

        // Cart Products
            $arr_coupons = [];
            $arr_brands = [];
            $arr_products = [];
            $arr_categories = [];

            $assoc_arr_category = [];
            $asoc_arr_category_qty = [];

            $assoc_arr_brands = [];
            $asoc_arr_brand_qty = [];

            $cartProducts = Cart::where('user_id',Auth::id())->get();
            foreach ($cartProducts as $p) {
                $product = Product::find($p->product_id);

                array_push($arr_products, $p->product_id);
                array_push($arr_categories, $product->category_id);

                if(isset($product->brand)){
                    array_push($arr_brands, $product->brand);
                }

                
                // get total cart qty per category
                if(in_array($product->category_id, $assoc_arr_category)) {
                    if(false !== $key = array_search($product->category_id, $assoc_arr_category)) {
                        // $arr_qty = $asoc_arr_category_qty[$key];
                        $qty = $asoc_arr_category_qty[$key]+$p->qty;
                        $asoc_arr_category_qty[$key] = $qty;
                    }
                } else {
                    array_push($assoc_arr_category, $product->category_id);
                    array_push($asoc_arr_category_qty, $p->qty);
                }

                // get total cart qty per brand
                if($product->brand != ''){
                    if(in_array($product->brand, $assoc_arr_brands)) {
                        if(false !== $key = array_search($product->brand, $assoc_arr_brands)) {
                            // $arr_qty = $asoc_arr_brand_qty[$key];
                            $qty = $asoc_arr_brand_qty[$key]+$p->qty;
                            $asoc_arr_brand_qty[$key] = $qty;
                        }
                    } else {
                        array_push($assoc_arr_brands, $product->brand);
                        array_push($asoc_arr_brand_qty, $p->qty);
                    }
                }
            }
        //
        
    // Purchase Product, Category, Brand Only
        $purchasedCoupons = 
            Coupon::where('status','ACTIVE')
            ->where('availability',1)
            ->where('purchase_combination_counter',1)
            ->where('activation_type','auto')
            ->where(function ($orWhereQuery){
                $orWhereQuery->orwhereNotNull('purchase_product_id')
                      ->orwhereNotNull('purchase_product_cat_id')
                      ->orwhereNotNull('purchase_product_brand');
            })->get();

        foreach ($purchasedCoupons as $coupon) {
            if(isset($coupon->purchase_product_id)){
                $products   = explode('|',$coupon->purchase_product_id);
                foreach($products as $prodid){
                    if(in_array($prodid, $arr_products)){
                        array_push($arr_coupons, $coupon->id);
                    }
                }
            }

            if(isset($coupon->purchase_product_cat_id)){
                $categories = explode('|',$coupon->purchase_product_cat_id);
                foreach($categories as $catid){
                    if(in_array($catid, $arr_categories)){
                        array_push($arr_coupons, $coupon->id);
                    }
                }
            }

            if(isset($coupon->purchase_product_brand)){
                $brands     = explode('|',$coupon->purchase_product_brand);
                foreach($brands as $brand){
                    if(in_array($brand, $arr_brands)){
                        array_push($arr_coupons, $coupon->id);
                    }
                }
            }
        }

        $purchased_coupons = Coupon::whereIn('id',$arr_coupons)->get();
    //

    // Purchase Combination = Product ID or Product Category or Product Brand + total amount + total quantity
        $purchasedCombinationCoupons = 
        Coupon::where('status','ACTIVE')
        ->where('availability',1)
        ->where('purchase_combination_counter','>',1)
        ->where('activation_type','auto')
        ->where(function ($orWhereQuery){
            $orWhereQuery->orwhereNotNull('purchase_product_id')
              ->orwhereNotNull('purchase_product_cat_id')
              ->orwhereNotNull('purchase_product_brand')
              ->orwhereNotNull('purchase_amount')
              ->orwhereNotNull('purchase_qty');
        })->get();

        $combination_counter = '';
        $arr_purchase_combination_coupons = [];
        foreach($purchasedCombinationCoupons as $coupon){
            $purchasetype = explode('|',$coupon->purchase_combination);

            foreach($purchasetype as $type){
                // Check Products
                    if($type == 'product'){
                        if(isset($coupon->purchase_product_id)){
                            $products   = explode('|',$coupon->purchase_product_id);
                            foreach($products as $prodid){
                                if(in_array($prodid, $arr_products)){
                                    $combination_counter .= 'product|';
                                    break;
                                }
                            }
                        }

                        if(isset($coupon->purchase_product_cat_id)) {
                            $categories = explode('|',$coupon->purchase_product_cat_id);
                            foreach($categories as $catid){
                                if(in_array($catid, $arr_categories)){
                                    $combination_counter .= 'product|';
                                    break;
                                }
                            }
                        }

                        if(isset($coupon->purchase_product_brand)) {
                            $brands     = explode('|',$coupon->purchase_product_brand);
                            foreach($brands as $brand){
                                if(in_array($brand, $arr_brands)){
                                    $combination_counter .= 'product|';
                                    break;
                                }
                            }
                        }
                    }
                //

                $arr_prod = [];
                if(isset($coupon->purchase_product_id)){
                    $prod   = explode('|',$coupon->purchase_product_id);
                    foreach($prod as $p){
                        array_push($arr_prod, $p);
                    }
                }

                if(isset($coupon->purchase_product_cat_id)) {
                    $categories = explode('|',$coupon->purchase_product_cat_id);
                    foreach($categories as $cat){
                        $xx = Product::where('category_id',$cat)->get();
                        foreach($xx as $x){
                            array_push($arr_prod, $x->id);
                        }
                    }
                }

                if(isset($coupon->purchase_product_brand)) {
                    $brands = explode('|',$coupon->purchase_product_brand);
                    foreach($brands as $brand){
                        $xx = Product::where('brand',$brand)->get();
                        foreach($xx as $x){
                            array_push($arr_prod, $x->id);
                        }
                    }
                }

                $products = Product::whereIn('id',$arr_prod)->get();

                if($type == 'qty'){
                    foreach($products as $prod){
                        $cartData = Cart::where('user_id',Auth::id())->where('product_id',$prod->id);
                        // check if product exist on cart
                        if($cartData->exists()){

                            $cart = $cartData->first();
                            if($coupon->purchase_qty_type == 'min'){
                                if($cart->qty >= $coupon->purchase_qty){
                                    $combination_counter .= 'qty|';
                                    break;
                                }
                            }
                            if($coupon->purchase_qty_type == 'max'){
                                if($cart->qty <= $coupon->purchase_qty){
                                    $combination_counter .= 'qty|';
                                    break;
                                }
                            }
                        }
                    }
                }

                if($type == 'amount'){
                    foreach($products as $prod){
                        $cartData = Cart::where('user_id',Auth::id())->where('product_id',$prod->id);
                        // check if product exist on cart
                        if($cartData->exists()){
                            $cart = $cartData->first();
                            $price = $prod->discountedprice*$cart->qty;

                            if($coupon->purchase_amount_type == 'min'){
                                if($price >= $coupon->purchase_amount){
                                    $combination_counter .= 'amount|';
                                    break;
                                }
                            }
                            if($coupon->purchase_amount_type == 'max'){
                                if($price <= $coupon->purchase_amount){
                                    $combination_counter .= 'amount|';
                                    break;
                                }
                            }
                        }
                    }
                }
            }

            if($combination_counter == $coupon->purchase_combination){
                array_push($arr_purchase_combination_coupons, $coupon->id);
            }
            $combination_counter = '';
        }

        $purchased_combined_coupons = Coupon::whereIn('id',$arr_purchase_combination_coupons)->get();
        
    //

        $collectibles = collect($couponsMinTotalAmount)
            ->merge($couponsMaxTotalAmount)
            ->merge($couponsMinTotalQty)
            ->merge($couponsMaxTotalQty)
            ->merge($purchased_coupons)
            ->merge($purchased_combined_coupons)
            ->merge($couponEvents)
            ->merge($couponeventspecific);


        $arr_coupon_availability = [];
        foreach($collectibles as $coupon){
            array_push($arr_coupon_availability,$coupon->id);
        }

        $coupons = Coupon::where('status','ACTIVE')->where('availability',1)->where('activation_type','auto')->where('customer_scope','all');
        if($request->page_name == 'cart'){
            $coupons = $coupons->whereNull('location')->orderBy('name','asc');
            $coupon_customer = Coupon::where('status','ACTIVE')->where('availability',1)->where('activation_type','auto')->where('customer_scope','specific')->whereNull('location')->get();
        } else {
            $coupons = $coupons->where('amount_discount_type',1)->where(function ($orWhereQuery){
                $orWhereQuery->orwhereNotNull('location');
                    // ->orwhereNotNull('amount')
                    // ->orwhereNotNull('percentage');
                })->orderBy('name','asc');

            $coupon_customer = Coupon::where('status','ACTIVE')->where('availability',1)->where('activation_type','auto')->where('customer_scope','specific')->where('amount_discount_type',1)->where(function ($orWhereQuery){
                $orWhereQuery->orwhereNotNull('location');
                    // ->orwhereNotNull('amount')
                    // ->orwhereNotNull('percentage');
                })->get();
        }

        $coupons = $coupons->get();

        $coupon_customer = Coupon::where('status','ACTIVE')->where('availability',1)->where('activation_type','auto')->where('customer_scope','specific')->get();

        $arr_customer_coupons = [];
        $arr_customer_id = [];
        foreach($coupon_customer as $coupon){
            $customerID = explode('|',$coupon->scope_customer_id);
            foreach($customerID as $id){
                array_push($arr_customer_id, $id);
            }

            if(in_array(auth()->user()->email, $arr_customer_id)){
                array_push($arr_customer_coupons, $coupon->id);
            }
        }

        if(empty($arr_customer_coupons)){
            $allCoupons = $coupons;
        } else {
            $customerCoupons = Coupon::where('status','ACTIVE')->where('availability',1)->where('activation_type','auto')->whereIn('id',$arr_customer_coupons)->get();
            // all or specific coupons
            $allCoupons = collect($customerCoupons)->merge($coupons);
        }

        // get remaining usage
        $arr_coupon_usage_limit = [];
        foreach($allCoupons as $coupon){
            $totalusage = CouponSale::where('order_status','PAID')->where('coupon_id',$coupon->id)->count();
            $remaining = $coupon->customer_limit-$totalusage;

            array_push($arr_coupon_usage_limit, $remaining);
        }


        return response()->json([
            'coupons' => $allCoupons, 
            'availability' => $arr_coupon_availability, 
            'remaining' => $arr_coupon_usage_limit,
            'cart_per_brand' => $assoc_arr_brands,
            'cart_qty_per_brand' => $asoc_arr_brand_qty,
            'cart_per_category' => $assoc_arr_category,
            'cart_qty_per_category' => $asoc_arr_category_qty
        ]);
    }

    public function get_brands(Request $request)
    {
        $categories = explode('|',$request->categories);

        $arr_categories = []; 
        foreach($categories as $category) {
            if($category != ''){
                array_push($arr_categories, $category);    
            }
        }

        $brands = Product::whereNotNull('brand')->whereIn('category_id',$arr_categories)->distinct()->get(['brand']);

        if(count($brands)){
            return response()->json(['success' => true, 'brands' => $brands]);
        } else {
            return response()->json(['success' => false]);
        }
        
    }

}
