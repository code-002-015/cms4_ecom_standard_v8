<?php

namespace App\Http\Controllers\EcommerceControllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Helpers\Webfocus\Setting;

use App\EcommerceModel\GiftCertificate;
use App\EcommerceModel\SalesPayment;
use App\EcommerceModel\SalesHeader;
use App\EcommerceModel\SalesDetail;
use App\EcommerceModel\Branch;
use App\EcommerceModel\Cart;
use App\Deliverablecities;
use App\ProductCategory;


use App\Page;
use App\User;



use App\Mail\SalesCompletedRegistered;
use App\Mail\SalesCompletedAdmin;
use App\Mail\SalesCompleted;

use Carbon\Carbon;
use Session;
use Cookie;
use DB;


class KioskController extends Controller
{
    public function home()
    {
        session()->forget('shid');
        return view('theme.'.env('FRONTEND_TEMPLATE').'.ecommerce.kiosk.home');
    }

    public function menu(Request $request)
    {
        $page = new Page();
        $page->name = 'Menu';

        $productCategories = ProductCategory::where('status', 'PUBLISHED')->select('id','name')->orderBy('name','desc')->get();

        $miscs = DB::table('products')->where('for_sale', '1')->whereNull('deleted_at')->where('status','PUBLISHED')->where('for_sale_kiosk','1')->where('is_misc','1')->select('name')->distinct()->get();


        return view('theme.'.env('FRONTEND_TEMPLATE').'.ecommerce.kiosk.menu',compact('productCategories','page','miscs'));

    }

    public function cart()
    {
        $cart = Cart::where('user_id',Auth::id())->get();

        $setting = \App\Setting::find(1);
        $exp_categories = explode('|',$setting->kiosk_express_categories);
        $arr_cart_product_categories = [];
        foreach($exp_categories as $cat){
            array_push($arr_cart_product_categories, $cat);
        }

        $expCounter = 0;
        foreach($cart as $c){
            $product = \App\Product::find($c->product_id);
            if (in_array($product->category_id, $arr_cart_product_categories)){
                $expCounter++;
            }
        }

        $totalProducts = $cart->count();

        $page = new Page();
        $page->name = 'Cart';

        return view('theme.'.env('FRONTEND_TEMPLATE').'.ecommerce.kiosk.cart', compact('cart', 'totalProducts','page','expCounter'));
    }

    public function batch_update(Request $request)
    {
        if (Cart::where('user_id', auth()->id())->count() == 0) {
            return redirect()->route('kiosk.menu');
        }

        $data = $request->all();

        $products = $data['record_id'];
        foreach($products as $key => $product){
            Cart::where('product_id',$product)->where('user_id', auth()->id())->update([
                'qty' => $request->quantity[$key]
            ]);
        }

        if($request->is_express == 0){
            return redirect()->route('kiosk.checkout');
        } else {
            return redirect()->route('kiosk.express-checkout');
        }
        
    }

    public function checkout()
    {

        $profile = Auth::user()->profile;
        $products = Cart::where('user_id',Auth::id())->get();
        $locations = Deliverablecities::distinct()->orderBy('name')->get(['name']);
        $coupon = 0;

        $counter = 0;
        $baka = 0;
        $lechon = 0;

        foreach($products as $p){
            if(!empty($p->coupon_code)){  
                $coupon=$p->coupon_amount;
                break;
            }

            if($p->product_id == 42){
                $baka = 1;
            }

            if($p->product->production_item == 1){
                $lechon = 1;
            }

            if($lechon == 1 || $baka == 1){
                $counter++;
            }
        }


        $user = Auth::user();

        if ($products->count() == 0) {
            return redirect()->route('kiosk.menu');
        }

        return view('theme.'.env('FRONTEND_TEMPLATE').'.ecommerce.kiosk.checkout', compact('user','profile', 'products','locations','coupon','counter'));
    }

    public function save_sales(Request $request)
    {
        $user = auth()->user();
        $carts = Cart::where('user_id',$user->id)->get();

        $dn = explode(" - ", $request->dateneeded);
        $date_needed = date('Y-m-d H:i:s',strtotime($dn[0]." ".$dn[1]));

        if($request->shipping_type == 'storepickup'){
            $delivery_type = 'Store Pickup';
            $outlet = $request->delivery_branch;
            $customer_delivery_adress = $request->delivery_branch;
            $customer_location = '';
        } else {
            $delivery_type = 'Door to door delivery';
            if($request->location == 'Other'){
                $customer_delivery_adress = $request->delivery_address;  
            }
            else{
                $customer_delivery_adress = $request->delivery_address.", ".$request->location;  
            }

            $customer_location = $request->location;
            $outlet = '';
        }

        $ran = microtime();
        $today = getdate();
        $requestId = $today[0].substr($ran, 2,6);

        if(Carbon::now()->format('H:i') > Setting::info()->cutoff){
            $forecast_date = date('Y-m-d', strtotime('+1 days'));
        } else {
            $forecast_date = date('Y-m-d');
        }

        $salesHeader = SalesHeader::create([
            'user_id' => $user->id,
            'email' => $request->email,
            'order_number' => $requestId,
            'customer_name' => $request->uname1,
            'customer_contact_number' => $request->mobile,
            'customer_address' => $customer_delivery_adress,
            'customer_delivery_adress' => $customer_delivery_adress,
            'delivery_tracking_number' => '',
            'delivery_type' => $delivery_type,
            'delivery_fee_amount' => $request->delivery_fee,
            'order_source' => Cookie::get('branch'),
            'gross_amount' => $request->total_amount,
            'tax_amount' => 0,
            'net_amount' => $request->total_amount,
            'discount_amount' => 0,
            'payment_status' => 'UNPAID',
            'delivery_status' => '',
            'status' => 'active',
            'currency' => 'PHP',
            'customer_location' => $customer_location,
            'instruction' => $request->instruction,
            'agent' => $request->agent,
            'contact_person' => $request->cperson,
            'outlet' => $outlet,
            'origin' => Cookie::get('origin'),
            'forecast_date' => $forecast_date
        ]);

        $salesHeader->update([
            'order_number' => sprintf('%07d', $salesHeader->id)
        ]);

        $grand_gross = 0;
        $grand_tax = 0;

        $coupon_code = 0;
        $coupon_amount = 0;
        $saved_items = '';

        foreach ($carts as $cart) {
            if(!empty($cart->coupon_code)){
                
                $ccode = explode("|", $cart->coupon_code);
                foreach($ccode as $cd){
                    $code = explode(":",$cd);

                    $coupon = $this->use_coupon($code[0],$salesHeader->id);

                    if(!empty($coupon)){

                        $payment_coupon = SalesPayment::create([
                            'sales_header_id' => $salesHeader->id,
                            'payment_type' => 'Gift Cert',
                            'amount' => $code[1],
                            'status' => 'PENDING',
                            'payment_date' => date('Y-m-d'),
                            'receipt_number' => $code[0],
                            'created_by' => Auth::id()
                        ]);
                    }
                } 
            }

            $product = $cart->product;
            $gross_amount = ($product->price * $cart->qty) + ($cart->paella_price * $cart->qty);
            $tax_amount = $gross_amount - ($gross_amount/1.12);
            $grand_gross += $gross_amount;
            $grand_tax += $tax_amount;


            $data['price'] = $product->price;
            $data['tax'] = $data['price'] - ($data['price']/1.12);
            $data['other_cost'] = 0;
            $data['net_price'] = $data['price'] - ($data['tax'] + $data['other_cost']);
           
            SalesDetail::create([
                'sales_header_id' => $salesHeader->id,
                'product_id' => $product->id,
                'product_name' => $product->name,
                'product_category' => $product->category_id,
                'price' => $product->price,
                'cost' => 0,
                'tax_amount' => $tax_amount,
                'promo_id' => 0,
                'promo_description' => '',
                'discount_amount' => 0,
                'gross_amount' => $gross_amount,
                'net_amount' => $gross_amount,
                'qty' => $cart->qty,
                'paella_qty' => $cart->qty,
                'uom' => $product->uom,
                'size' => $product->size ?? "",
                'no_of_pax' => $product->no_of_pax ?? "",
                'paella_price' => $cart->paella_price,
                'other_cost' => 0,
                'other_cost_description' => '',
                'created_by' => $user->id,
                'delivery_date' => $date_needed
            ]);

            $saved_items .= $cart->qty." x ".$product->name.", ";
        }

        Cart::where('user_id', $user->id)->delete();
        session::put('shid', $salesHeader->id); 

        return redirect(route('kiosk.success'));

        
    }

    public function express_checkout()
    {
        $user = auth()->user();

        $ran = microtime();
        $today = getdate();
        $requestId = $today[0].substr($ran, 2,6);


        $branch = Branch::where('name',Cookie::get('branch'))->first();

        $carts = Cart::where('user_id',$user->id)->get();
        $subtotal = $carts->sum('itemTotalPrice');
        $coupon = 0;
        foreach($carts as $cart){
            if(!empty($cart->coupon_code)){  
                $coupon = $cart->coupon_amount;
                break;
            }
        }

        $totalAmount = $subtotal-$coupon;

        $salesHeader = SalesHeader::create([
            'user_id' => $user->id,
            'email' => $branch->email_address,
            'order_number' => $requestId,
            'customer_name' => Cookie::get('branch'),
            'customer_contact_number' => $branch->contact_nos,
            'customer_address' => $branch->address,
            'customer_delivery_adress' => '',
            'delivery_tracking_number' => '',
            'delivery_type' => 'Store Pickup',
            'delivery_fee_amount' => 0,
            'order_source' => Cookie::get('branch'),
            'gross_amount' => $totalAmount,
            'tax_amount' => 0,
            'net_amount' => $totalAmount,
            'discount_amount' => 0,
            'payment_status' => 'UNPAID',
            'delivery_status' => '',
            'status' => 'active',
            'currency' => 'PHP',
            'customer_location' => $branch->address,
            'instruction' => '',
            'agent' => '',
            'contact_person' => '',
            'outlet' => Cookie::get('branch'),
            'origin' => Cookie::get('origin'),
            'forecast_date' => date('Y-m-d')
        ]);

        $salesHeader->update([
            'order_number' => sprintf('%07d', $salesHeader->id)
        ]);

        $grand_gross = 0;
        $grand_tax = 0;

        $saved_items = '';

        $carts = Cart::where('user_id',$user->id)->get();
        foreach ($carts as $cart) {
            if(!empty($cart->coupon_code)){
                
                $ccode = explode("|", $cart->coupon_code);
                foreach($ccode as $cd){
                    $code = explode(":",$cd);

                    $coupon = $this->use_coupon($code[0],$salesHeader->id);

                    if(!empty($coupon)){

                        $payment_coupon = SalesPayment::create([
                            'sales_header_id' => $salesHeader->id,
                            'payment_type' => 'Gift Cert',
                            'amount' => $code[1],
                            'status' => 'PENDING',
                            'payment_date' => date('Y-m-d'),
                            'receipt_number' => $code[0],
                            'created_by' => Auth::id()
                        ]);
                    }
                } 
            }

            $product = $cart->product;
            $gross_amount = ($product->price * $cart->qty) + ($cart->paella_price * $cart->qty);
            $tax_amount = $gross_amount - ($gross_amount/1.12);
            $grand_gross += $gross_amount;
            $grand_tax += $tax_amount;


            $data['price'] = $product->price;
            $data['tax'] = $data['price'] - ($data['price']/1.12);
            $data['other_cost'] = 0;
            $data['net_price'] = $data['price'] - ($data['tax'] + $data['other_cost']);
           
            SalesDetail::create([
                'sales_header_id' => $salesHeader->id,
                'product_id' => $product->id,
                'product_name' => $product->name,
                'product_category' => $product->category_id,
                'price' => $product->price,
                'cost' => 0,
                'tax_amount' => $tax_amount,
                'promo_id' => 0,
                'promo_description' => '',
                'discount_amount' => 0,
                'gross_amount' => $gross_amount,
                'net_amount' => $gross_amount,
                'qty' => $cart->qty,
                'paella_qty' => $cart->qty,
                'uom' => $product->uom,
                'size' => $product->size ?? "",
                'no_of_pax' => $product->no_of_pax ?? "",
                'paella_price' => $cart->paella_price,
                'other_cost' => 0,
                'other_cost_description' => '',
                'created_by' => $user->id,
                'delivery_date' => Carbon::now()
            ]);

            $saved_items .= $cart->qty." x ".$product->name.", ";
        }

        Cart::where('user_id', $user->id)->delete();
        session::put('shid', $salesHeader->id); 

        return redirect(route('kiosk.success'));
        
    }

    public function use_coupon($code,$sales_id){

        $coupon = GiftCertificate::whereCode($code)->whereStatus('Unused')->first();
    
        if(empty($coupon)){
            return false;
        }

        $use_coupon = $coupon->update([
            'status' => 'Used',
            'sales_header_id' => $sales_id
        ]);

        return $coupon;
    }

    public function email_to_branch($salesHeader){
        $branch = Branch::where('name',$salesHeader->outlet)->first();
        if(!empty($branch)){
            if(strlen($branch->email_address) > 2){
                $email_act = Mail::to(env($branch->email_address))->send(new SalesCompletedAdmin($salesHeader));
            }
        }
        return true;
    }

    public function success()
    {
        $sales = SalesHeader::find(session::get('shid'));

        return view('theme.'.env('FRONTEND_TEMPLATE').'.ecommerce.kiosk.success',compact('sales'));
    }


}
