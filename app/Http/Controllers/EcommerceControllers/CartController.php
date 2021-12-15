<?php

namespace App\Http\Controllers\EcommerceControllers;


use App\Mail\SalesCompleted;
use Illuminate\Support\Facades\Mail;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use App\Helpers\Setting;
use App\Helpers\PaynamicsHelper;


// Models
use App\Models\SalesPayment;
use App\Models\SalesHeader;
use App\Models\SalesDetail;

use App\Models\Product;
use App\Models\Cart;


// use App\Models\CouponCartDiscount;
// use App\Models\CustomerCoupon;
// use App\Models\CouponCart;
// use App\Models\CouponSale;
// use App\Models\Coupon;

use App\Models\PaynamicsLog;
use App\Models\Page;


use Carbon\Carbon;
use Redirect;
use DateTime;
use Auth;
use DB;


class CartController extends Controller
{
    public function store(Request $request)
    {       
        $product = Product::whereId($request->product_id)->first();

        $promo = DB::table('promos')->join('promo_products','promos.id','=','promo_products.promo_id')->where('promos.status','ACTIVE')->where('promos.is_expire',0)->where('promo_products.product_id',$request->product_id);

        if($promo->count() > 0){
            $discount = $promo->max('promos.discount');

            $percentage = ($discount/100);
            $discountedAmount = ($product->price * $percentage);

            $price = number_format(($product->price - $discountedAmount),2,'.','');
        } else {
            $price = number_format($product->price,2,'.','');
        }

        if (auth()->check()) {
            
            $cart = Cart::where('product_id', $request->product_id)
                ->where('user_id', Auth::id())
                ->first();

            if (!empty($cart)) {
                //$newQty = $cart->qty + $request->qty;
                $newQty = $request->qty;
                $save = $cart->update([
                    'qty' => $newQty,
                    'price' => $price
                ]);
            } else {
                $save = Cart::create([
                    'product_id' => $request->product_id,
                    'user_id' => Auth::id(),
                    'qty' => $request->qty,
                    'price' => $price
                ]);
            }

        } 
        else 
        {
            $cart = session('cart', []);
            $not_exist = true;

            foreach ($cart as $key => $order) {
                if ($order->product_id == $request->product_id) {
                    $cart[$key]->qty = $request->qty;
                    $cart[$key]->price = $price;
                    $not_exist = false;
                    break;
                }
            }

            if ($not_exist) {
                $order = new Cart();
                $order->product_id = $request->product_id;
                $order->qty = $request->qty;
                $order->price = $price;

                array_push($cart, $order);
            }

            session(['cart' => $cart]);
           

        }
       
        $inventory_remark = true;

        if($inventory_remark){
            return response()->json([
                'success' => true,
                'totalItems' => Setting::EcommerceCartTotalItems()                
            ]);
            
        }else{
            return response()->json([
                'success' => false,
                'totalItems' => Setting::EcommerceCartTotalItems()                
            ]);
        }
    }

    public function view()
    {   
        if (auth()->check()) {
            $cart = Cart::where('user_id',Auth::id())->get();
            $totalProducts = $cart->count();

        } else {
            $cart = session('cart', []);
            $totalProducts = count(session('cart', []));
        }

        $page = new Page();
        $page->name = 'Cart';
        //$coupons = Coupon::where('status','ACTIVE')->where('activation_type','auto')->get();


        //return view('theme.'.env('FRONTEND_TEMPLATE').'.ecommerce.cart.cart', compact('cart', 'totalProducts','page','coupons'));
        return view('theme.ecommerce.pages.cart', compact('cart', 'totalProducts','page'));
    }

    public function remove_product(Request $request)
    {

        if (auth()->check()) {
            $delete = Cart::whereId($request->product_remove_id)->delete();
        } else {
            $cart = session('cart', []);
            $index = (int) $request->product_remove_id;
            if (isset($cart[$index])) {
                unset($cart[$index]);
            }
            session(['cart' => $cart]);
        }

        return back();
    }


    public function ajax_update(Request $request)
    {
        if (auth()->check()) {            
            if (Cart::where('user_id', auth()->id())->count() == 0) {
                return;
            }
            $upd = Cart::where('product_id',$request->record_id)->where('user_id', auth()->id());

            $upd->update([
                'qty' => $request->quantity
            ]);

            $cart_qty = $upd->first();

            $price_before = $cart_qty->product->price*$cart_qty->qty;


            $carts = Cart::where('user_id', auth()->id())->get();
            $total_promo_discount = 0;
            $subtotal = 0;
            foreach($carts as $cart){
                $promo_discount = $cart->product->price-$cart->product->discountedprice;
                $total_promo_discount += $promo_discount*$cart->qty;
                $subtotal += $cart->product->price*$cart->qty;
            }
        } else {
            $cart = session('cart', []);
                foreach ($cart as $key => $order) {
                    if ($order->product_id == $request->record_id) {
                        $cart[$key]->qty = $request->quantity;
                        break;
                    }
                }
            session(['cart' => $cart]);
        }

        return response()->json([
            'success' => true,
            'total_promo_discount' => $total_promo_discount,
            'subtotal' => $subtotal,
            'recordid' => $request->record_id,
            'price_before' => $price_before        
        ]);
    }

    public function batch_update(Request $request)
    {
        if (auth()->check()) {            
            if (Cart::where('user_id', auth()->id())->count() == 0) {
                return redirect()->route('product.front.list');
            }

            for ($x = 1; $x <= $request->total_products; $x++) {
                $upd = Cart::whereId($request->record_id[$x])->where('user_id', auth()->id())->update([
                    'qty' => $request->quantity[$x]
                ]);
              
            }

            CouponCart::where('customer_id',Auth::id())->delete();
            if($request->coupon_counter > 0){
                $data = $request->all();
                $coupons = $data['couponid'];
                $product = $data['coupon_productid'];
                $usage = $data['couponUsage'];

                foreach($coupons as $key => $c){
                    $coupon = Coupon::find($c);

                    if($coupon->status == 'ACTIVE'){
                        CouponCart::create([
                            'coupon_id' => $coupon->id,
                            'product_id' => $product[$key] == 0 ? NULL : $product[$key],
                            'customer_id' => Auth::id(),
                            'total_usage' => $usage[$key]
                        ]);
                    }
                }
            }

            CouponCartDiscount::where('customer_id',Auth::id())->delete();
            CouponCartDiscount::create([
                'customer_id' => Auth::id(),
                'coupon_discount' => $request->coupon_total_discount
            ]);

            return redirect()->route('cart.front.checkout');
        } else {
            $cart = session('cart', []);

            for ($x = 1; $x <= $request->total_products; $x++) {
                foreach ($cart as $key => $order) {
                    if ($order->product_id == $request->record_id[$x]) {
                        $cart[$key]->qty = $request->quantity[$x];
                        break;
                    }
                }
            }

            session(['cart' => $cart]);

            return redirect()->route('customer-front.login');
        }
    }

    public function pay_again($id){
        $r = SalesHeader::findOrFail($id);

        $sales = 
        $urls = [
            'notification' => route('cart.payment-notification'),
            'result' => route('profile.sales'),
            'cancel' => route('profile.sales'),
        ];
       
        $base64Code = PaynamicsHelper::payNow($r->order_number, Auth::user(), $r->items, number_format($r->net_amount, 2, '.', ''), $urls, false ,number_format($r->delivery_fee_amount, 2, '.', ''), $r->discount_amount);
         return view('theme.paynamics.sender', compact('base64Code'));
    }

    public function next_order_number(){
        $last_order = SalesHeader::whereDate('created_at', Carbon::today())->orderBy('created_at','desc')->first();
        if(empty($last_order)){
            $next_number = date('Ymd')."-0001";
        }
        else{
            $order_number = explode("-",$last_order->order_number);
            if(!isset($order_number[1])){
                $next_number = date('Ymd')."-0001";
            }
            else{

                $next_number = date('Ymd')."-".str_pad(($order_number[1] + 1), 4, '0', STR_PAD_LEFT);
            }
        }
        return $next_number;
    }

    public function save_sales(Request $request) 
    { 
        $total_cart_items = Cart::where('user_id',Auth::id())->count();
        if($total_cart_items == 0){
            return redirect()->route('profile.sales');
        }
        $customer_delivery_adress = $request->delivery_address ?? ' ';
        $customer_name = Auth::user()->fullName;
        $customer_contact_number =  $request->mobile ?? Auth::user()->mobile;
        
        $coupon_total_discount = number_format($request->coupon_total_discount,2,'.','');

        $totalPrice = $request->total_amount;
        $requestId = $this->next_order_number();  
        $member = Auth::user();


        $cdata = Auth::user();
        $custype = 'personal';
        if($cdata->customer_type == 'business' && $cdata->is_verified == 1){
            $custype = 'business';
        }

        $salesHeader = SalesHeader::create([
            'user_id' => auth()->id(),
            'order_number' => $requestId,
            'customer_name' => $customer_name,
            'customer_contact_number' => $customer_contact_number,
            'customer_address' => $customer_delivery_adress,
            'customer_delivery_adress' => $customer_delivery_adress,
            'delivery_tracking_number' => ' ',
            'delivery_fee_amount' => number_format($request->delivery_fee,2,'.',''),
            'other_instruction' => $request->instruction,
            'delivery_courier' => ' ',
            'delivery_type' => $request->shipping_type,
            'gross_amount' => number_format($totalPrice,2,'.','') ,
            'tax_amount' => 0,
            'net_amount' => number_format($totalPrice,2,'.',''),
            'discount_amount' => $coupon_total_discount,
            'payment_status' => 'UNPAID',
            'delivery_status' => 'Waiting for Payment',
            'status' => 'active',
            'customer_type' => $custype
        ]);
     
        $carts = Cart::where('user_id',Auth::id())->get();

        $grand_gross = 0;
        $grand_tax = 0;

        $coupon_code = 0;
        $coupon_amount = 0;
        $totalQty = 0;
        foreach ($carts as $cart) {
            
            $totalQty += $cart->qty;

            $product = $cart->product;
            $gross_amount = (number_format($product->discountedprice,2,'.','') * $cart->qty);
            $tax_amount = $gross_amount - ($gross_amount/1.12);
            $grand_gross += $gross_amount;
            $grand_tax += $tax_amount;


            $data['price'] = number_format($product->discountedprice,2,'.','');
            $data['tax'] = $data['price'] - ($data['price']/1.12);
            $data['other_cost'] = 0;
            $data['net_price'] = $data['price'] - ($data['tax'] + $data['other_cost']);

            SalesDetail::create([
                'sales_header_id' => $salesHeader->id,
                'product_id' => $product->id,
                'product_name' => $product->name,
                'product_category' => $product->category_id,
                'price' => number_format($product->discountedprice,2,'.',''),              
                'tax_amount' => number_format($tax_amount,2,'.',''),
                'promo_id' => 0,
                'promo_description' => '',
                'discount_amount' => 0,
                'gross_amount' => number_format($gross_amount,2,'.',''),
                'net_amount' => number_format($gross_amount,2,'.',''),
                'qty' => $cart->qty,             
                'uom' => $product->uom,               
                'created_by' => Auth::id()
            ]);
          
        }
      
        $urls = [
            'notification' => route('cart.payment-notification'),
            'result' => route('profile.sales'),
            'cancel' => route('profile.sales'),
        ];
        
        if($request->coupon_counter > 0){
            $data = $request->all();
            $coupons = $data['couponid'];
            foreach($coupons as $coupon){
                $exist = CouponCart::where('customer_id',Auth::id())->where('coupon_id',$coupon)->exists();
                if(!$exist){
                   CouponCart::create([
                        'coupon_id' => $coupon,
                        'customer_id' => Auth::id()
                    ]); 
                } 
            }
        }

        $base64Code = PaynamicsHelper::payNow($requestId, Auth::user(), $carts, $totalPrice, $urls, false ,$request->delivery_fee, $coupon_total_discount);

        Cart::where('user_id', Auth::id())->delete();
        if($base64Code){
            if($request->coupon_counter > 0){
                $this->update_coupon_status($request,$salesHeader->id);    
            }
        }
        
        Mail::to(Auth::user())->send(new SalesCompleted($salesHeader));  
        
        return view('theme.paynamics.sender', compact('base64Code'));
       
    }

    public function receive_data_from_payment_gateway(Request $request)
    {
        logger($request);
        
        $paymentResponse = (isset($_POST['paymentresponse'])) ? $_POST['paymentresponse'] : null;

        if (empty($paymentResponse)) {
            return false;
        }

        
        $body = str_replace(" ", "+", $paymentResponse);

        try {
            $Decodebody = base64_decode($body);
            $ServiceResponseWPF = simplexml_load_string($Decodebody, 'SimpleXMLElement'); // new \SimpleXMLElement($Decodebody);
            $application = $ServiceResponseWPF->application;
            $responseStatus = $ServiceResponseWPF->responseStatus;

            $log = [
                'result_return' => $paymentResponse,
                'request_id' => $application->request_id,
                'response_id' => $application->response_id,
                'response_code' => $responseStatus->response_code,
                'response_message' => $responseStatus->response_message,
                'response_advise' => $responseStatus->response_advise,
                'timestamp' => $application->timestamp,
                'ptype' => $application->ptype,
                'rebill_id' => $application->rebill_id,
                'token_id' => (isset($application->token_id)) ? $application->token_id : '',
                'token_info' => (isset($application->token_info)) ? $application->token_info : '',
                'processor_response_id' => $responseStatus->processor_response_id,
                'processor_response_authcode' => $responseStatus->processor_response_authcode,
                'signature'  => $application->signature,
            ];
            $merchant = Setting::paynamics_merchant();
            $cert = $merchant['key']; //merchantkey

            $forSign = $application->merchantid . $application->request_id . $application->response_id . $responseStatus->response_code . $responseStatus->response_message . $responseStatus->
                response_advise . $application->timestamp . $application->rebill_id . $cert;

            $_sign = hash("sha512", $forSign);
           
            if ($_sign == $ServiceResponseWPF->application->signature) {

                $sales = SalesHeader::where('order_number', $application->request_id)->first();

                if (empty($sales)) {
                    $log['response_title'] = 'Sales Header not found';
                    PaynamicsLog::create($log);

                    return false;
                }

                if ($responseStatus->response_code == "GR001" || $responseStatus->response_code == "GR002") {
                    //SUCCESS TRANSACTION

                    $log['response_title'] = 'Success';
                    PaynamicsLog::create($log);

                    $sales->update([
                        'payment_status' => 'PAID',
                        'delivery_status' => 'Scheduled for Processing'
                    ]);
                    $update_payment = SalesPayment::create([
                        'sales_header_id' => $sales->id,
                        'amount' => $sales->net_amount,
                        'payment_type' => 'Paynamics-'.$application->ptype,
                        'status' => 'PAID',
                        'payment_date' => date('Y-m-d',strtotime($application->timestamp)),
                        'receipt_number' => $application->response_id,
                        'created_by' => Auth::id() ?? '1',
                        'response_body'=> $body,
                        'response_id' => $application->response_id,
                        'response_code' => $responseStatus->response_code
                    ]);

                    $c = CouponSale::where('sales_header_id',$sales->id);
                    $c->update(['order_status' => 'PAID']);

                    $coupons = $c->get();
                    foreach($coupons as $coupon){
                        $totalCustomer = CouponSale::where('coupon_id',$coupon->coupon_id)->count();
                        $cpn = Coupon::find($coupon->coupon_id);
                        
                        if($totalCustomer == $cpn->customer_limit){
                            $cpn->update(['status' => 'INACTIVE']);
                        }
                    }

                    $this->remove_cart_coupon();
                    
                } else if ($responseStatus->response_code == "GR053") {
                    $log['response_title'] = 'Cancelled';
                    PaynamicsLog::create($log);

                    $sales->update([
                        'payment_status' => 'CANCELLED'                        
                    ]);

                    CouponSale::where('sales_header_id',$sales->id)->update(['order_status' => 'PAID']);
                } else {

                    $log['response_title'] = 'Failed';
                    PaynamicsLog::create($log);

                    $sales->update([
                        'payment_status' => 'FAILED'
                    ]);

                    CouponSale::where('sales_header_id',$sales->id)->update(['order_status' => 'PAID']);
                }
            } else {
                $log['response_title'] = 'Invalid Signature';
                PaynamicsLog::create($log);
            }
        } catch(Exception $ex) {
            PaynamicsLog::create([
                'result_return' => $ex->getMessage(),
                'response_title' => 'Try catch Error'
            ]);
        }
    }

    public function generate_payment(Request $request){
        $salesHeader = SalesHeader::where('order_number',$request->order)->first();        
        $sign = $this->generateSignature('2amqVf04H9','PH00125',$request->order,str_replace(".", "", number_format($request->amount,2,'.','')),'PHP');
        $payment = $this->ipay($salesHeader,$request->amount,$sign);
        return response()->json([
                'success' => true,
                'order_number' => $request->order,
                'customer_contact_number' => Auth::user()->contact_mobile, 
                'amount' => number_format($request->amount,2,'.',''),
                'signature' => $sign
            ]);
    }

    public function remove_cart_coupon()
    {
        CouponCart::where('customer_id',Auth::id())->delete();
    }

    public function update_coupon_status($request,$salesid)
    {

        $data = $request->all();

        if(isset($request->freeproductid)){
            $freeproducts = $data['freeproductid'];
            // if has free products
            foreach($freeproducts as $productid){
                $product = Product::find($productid);

                SalesDetail::create([
                    'sales_header_id' => $salesid,
                    'product_id' => $productid,
                    'product_name' => $product->name,
                    'product_category' => $product->category_id,
                    'price' => 0,              
                    'tax_amount' => 0,
                    'promo_id' => 0,
                    'promo_description' => '',
                    'discount_amount' => 0,
                    'gross_amount' => 0,
                    'net_amount' => 0,
                    'qty' => 1,             
                    'uom' => $product->uom,               
                    'created_by' => Auth::id()
                ]);
            }
        }

        $coupons = $data['couponid'];
        foreach($coupons as $c){
            $coupon = Coupon::find($c);

            $cart = CouponCart::where('customer_id',Auth::id())->where('coupon_id',$coupon->id);

            if($cart->exists()){
                $ct = $cart->first();

                if(isset($ct->product_id)){
                    $productid = $ct->product_id;
                } else {
                    $productid = NULL;
                }            
            } else {
                $productid = NULL;
            }

            CouponSale::create([
                'customer_id' => Auth::id(),
                'coupon_id' => $c,
                'coupon_code' => $coupon->coupon_code,
                'sales_header_id' => $salesid,
                'product_id' => $productid
            ]);   
        }
    }
}
