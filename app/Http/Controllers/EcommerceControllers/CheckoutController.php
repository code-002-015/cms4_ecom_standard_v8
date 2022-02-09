<?php

namespace App\Http\Controllers\EcommerceControllers;

use App\AutoshipModel\Autoship;
use App\AutoshipModel\AutoshipDetail;
use App\Models\Cart;
use App\Models\SalesDetail;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\SalesHeader;
use App\Models\Branch;
use Auth;
use App\Deliverablecities;

class CheckoutController extends Controller
{

    public function checkout()
    {

        $profile = Auth::user()->profile;
        $products = Cart::where('user_id',Auth::id())->get();
        $branches = Branch::where('pickup_branch', 1)->get();
        $locations = Deliverablecities::distinct()->orderBy('name')->get(['name']);
        $coupon = 0;
        foreach($products as $p){
            if(!empty($p->coupon_code)){  
                $coupon=$p->coupon_amount;
                break;
            }
        }


        $user = Auth::user();

        if ($products->count() == 0) {
            return redirect()->route('product.front.list');
        }

        return view('theme.'.env('FRONTEND_TEMPLATE').'.ecommerce.cart.checkout-lydias', compact('user','profile', 'products','branches','locations','coupon'));
    }

    public function checkout_as_guest()
    {
        $products = session('cart', []); // Cart::where('user_id',Auth::id())->get();
        $branches = Branch::where('pickup_branch', 1)->get();
        $locations = Deliverablecities::distinct()->orderBy('name')->get(['name']);

        if (count($products) == 0) {
            return redirect()->route('product.front.list');
        }

        $products = collect($products);

        return view('theme.'.env('FRONTEND_TEMPLATE').'.ecommerce.cart.checkout-as-guest', compact('products','branches','locations'));
    }

    public function payment_completed() {


        // $products = Cart::where('user_id',Auth::id())->get();
        //    $user = Auth::user()->profile;
        //    $header = SalesHeader::create([
        //        'user_id' => Auth::id(),
        //        'order_number' => substr(md5(rand()),0,6),
        //        'customer_name' => $user->name,
        //        'customer_contact_number' => $user->phone,
        //        'customer_address' => $user->memberAddress,
        //        'customer_delivery_adress' => $user->deliveryAddress,
        //        'delivery_tracking_number' => substr(md5(rand()),0,6),
        //        'delivery_fee_amount' => 0,
        //        'gross_amount' => $products->sum('itemTotalPrice'),
        //        'tax_amount' => 0,
        //        'net_amount' => $products->sum('itemTotalPrice'),
        //        'discount_amount' => 0,
        //        'payment_status' => 'Completed',
        //        'delivery_status' => 'Processing Stock',
        //        'status' => 'Published',
        //        'currency' => 'Php'
        //    ])

        //    // foreach($products as $product){

        //    // }
        $delete_products = Cart::where('user_id',Auth::id())->delete();
        return redirect()->route('profile.sales')->with('message', 'Transaction Completed!');
    }

    public function transmit_data_to_payment_gateway(Request $request)
    {
        $isAutoShiped = ($request->has('option') && ($request->option == 1 || $request->option == 2)) ? $request->option : 0;

        $ran = microtime();
        $today = getdate();

        $requestId = $today[0].substr($ran, 2,6);
        $member = Auth::user()->profile;
        $carts = Cart::where('user_id',Auth::id())->get();
        $products = $carts;

        if ($products->count() == 0) {
            return redirect()->route('product.front.list');
        }

        $totalPrice = 0;
        // foreach ($carts as $cart) {
        //     $totalPrice += $cart->price * $cart->qty;
        // }

        $salesHeader = SalesHeader::create([
            'user_id' => auth()->id(),
            'order_number' => $requestId,
            'customer_name' => auth()->user()->fullName,
            'customer_contact_number' => $member->mobile,
            'customer_address' => $member->memberAddress,
            'customer_delivery_adress' => $member->deliveryAddress,
            'delivery_tracking_number' => '',
            'delivery_fee_amount' => 0,
            'gross_amount' => $totalPrice,
            'tax_amount' => 0,
            'net_amount' => 0,
            'discount_amount' => 0,
            'payment_status' => 'PAID',
            'delivery_status' => '',
            'status' => 'active',
            'currency' => 'PHP',
            'member_rank' => $member->class,
            'member_rank_seq' => 0,
            'sponsor_id' => $member->sponsor_id,
            'sponsor_rank' => (!empty($member->sponsor_id) ? $member->sponsor->class : 0),
        ]);

        $autoShip = null;
        if ($isAutoShiped) {
            if ($isAutoShiped == 2) {
                $nextDueDate = $salesHeader->created_at->addYear()->format('Y-m-d');
                $scheduleType = 'YEARLY';
            } else {
                $nextDueDate = $salesHeader->created_at->addMonthsNoOverflow(1)->format('Y-m-d');
                $scheduleType = 'MONTHLY';
            }


            $autoShip = Autoship::create([
                'user_id' => auth()->id(),
                'sales_id' => $salesHeader->id,
                'delivery_date' => $nextDueDate,
                'status' => 'PENDING',
                'schedule_type' => $scheduleType
            ]);
        }

        $grand_gross = 0;
        $grand_tax = 0;

        foreach ($carts as $cart) {

            $product = $cart->product;
            $gross_amount = $product->price * $cart->qty;
            $tax_amount = $gross_amount - ($gross_amount/1.12);
            $grand_gross += $gross_amount;
            $grand_tax += $tax_amount;


            $data['price'] = $product->price;
            $data['tax'] = $data['price'] - ($data['price']/1.12);
            $data['other_cost'] = 0;
            $data['net_price'] = $data['price'] - ($data['tax'] + $data['other_cost']);
            $data['rank'] = $member->class;
            $data['purchased_count'] = SalesHeader::where('user_id',Auth::id())->where('payment_status','paid')->count();

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
                'uom' => $product->uom,
                'retail_income' => $this->retail_income($data),
                'residual_income' => $this->residual_income($data),
                'rewards' => $this->rewards($data),
                'rank_advancement_bonus' => $this->rank_advancement_bonus($data),
                'rebate_sales_bonus' => $this->rebate_sales_bonus($data),
                'rainmaker_achievement_bonus' => $this->rainmaker_achievement_bonus($data),
                'regents_circle_bonus' => $this->regents_circle_bonus($data),
                'royal_crown_bonus' => $this->royal_crown_bonus($data),
                'replication_premium_incentive' => $this->replication_premium_incentive($data),
                'pv' => $product->point_value,
                'pv_gross' => ($product->point_value * $cart->qty),
                'cv' => $product->commissionable_value,
                'cv_gross' => ($product->commissionable_value * $cart->qty),
                'other_cost' => 0,
                'other_cost_description' => '',
                'retail_income_from_downline' => $this->retail_income_from_downline($data),
                'created_by' => Auth::id()
            ]);

            if ($isAutoShiped && $autoShip) {
                AutoshipDetail::create([
                    'autoship_header_id' => $autoShip->id,
                    'product_id' => $product->id,
                    'price' => $product->price,
                    'qty' => $cart->qty,
                    'uom' => $product->uom
                ]);
            }
        }

        $update_header = SalesHeader::whereId($salesHeader->id)->update([
            'gross_amount' => $grand_gross,
            'tax_amount' => $grand_tax,
            'net_amount' => $grand_gross
        ]);

        Cart::where('user_id', Auth::id())->delete();

        return view('theme.'.env('FRONTEND_TEMPLATE').'.ecommerce.cart.paynamics-sender', compact('products','requestId', 'member'));
    }

    public function receive_data_from_payment_gateway(Request $request)
    {
        try{
            if(isset($_POST['paymentresponse'])) {
                $body = $_POST['paymentresponse'];

                //// Sample paymentreponse code
//                 $body = str_replace(" ", "+", "PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz48U2VydmljZVJlc3BvbnNlV1BGIHhtbG5zOnhzZD0iaHR0cDovL3d3dy53My5vcmcvMjAwMS9YTUxTY2hlbWEiIHhtbG5zOnhzaT0iaHR0cDovL3d3dy53My5vcmcvMjAwMS9YTUxTY2hlbWEtaW5zdGFuY2UiPjxhcHBsaWNhdGlvbj48bWVyY2hhbnRpZD4wMDAwMDAxOTEyMTk0M0ZDM0JENzwvbWVyY2hhbnRpZD48cmVxdWVzdF9pZD4xNTc4NDY5OTk4ODAyMDYxPC9yZXF1ZXN0X2lkPjxyZXNwb25zZV9pZD4yOTk5NzkzNzY2MTMwNDM5OTMwMTwvcmVzcG9uc2VfaWQ+PHRpbWVzdGFtcD4yMDIwLTAxLTA4VDE1OjU3OjIzLjAwMDAwMCswODowMDwvdGltZXN0YW1wPjxyZWJpbGxfaWQgLz48c2lnbmF0dXJlPmI2MzE2MjNjZGQ2OWE5MzVkZGU0Y2I0Yzg5NWFlMDYxMjBiZDk0Yjc1NDc0OGFmZWI1NzQwNjE3MDk4ZDFjMzUzMzcxY2JhMjA4ZTk3YTNhYzI5YzNmYzY2MDVmNTA2ZjE2OGJhODY3MGJkM2Y3NjM0ZDQ2NDYzMGU3ZDE4ODBkPC9zaWduYXR1cmU+PHB0eXBlPkRQPC9wdHlwZT48L2FwcGxpY2F0aW9uPjxyZXNwb25zZVN0YXR1cz48cmVzcG9uc2VfY29kZT5HUjAwMTwvcmVzcG9uc2VfY29kZT48cmVzcG9uc2VfbWVzc2FnZT5UcmFuc2FjdGlvbiBTdWNjZXNzZnVsPC9yZXNwb25zZV9tZXNzYWdlPjxyZXNwb25zZV9hZHZpc2U+VHJhbnNhY3Rpb24gaXMgYXBwcm92ZWQ8L3Jlc3BvbnNlX2FkdmlzZT48cHJvY2Vzc29yX3Jlc3BvbnNlX2lkPkI0UE04M0QwPC9wcm9jZXNzb3JfcmVzcG9uc2VfaWQ+PHByb2Nlc3Nvcl9yZXNwb25zZV9hdXRoY29kZT5bMDAwXSBCT0cgUmVmZXJlbmNlIE5vOiAyMDIwMDEwODE1NTcyMSAjQjRQTTgzRDA8L3Byb2Nlc3Nvcl9yZXNwb25zZV9hdXRoY29kZT48L3Jlc3BvbnNlU3RhdHVzPjxzdWJfZGF0YSAvPjx0cmFuc2FjdGlvbkhpc3Rvcnk+PHRyYW5zYWN0aW9uIC8+PC90cmFuc2FjdGlvbkhpc3Rvcnk+PC9TZXJ2aWNlUmVzcG9uc2VXUEY+");

                $body = str_replace(" ", "+", $body);
                $Decodebody = base64_decode($body);
                echo "DECODEd : </br></br> ";

                $ServiceResponseWPF = simplexml_load_string($Decodebody, 'SimpleXMLElement'); // new \SimpleXMLElement($Decodebody);
                $application = $ServiceResponseWPF->application;

                $responseStatus = $ServiceResponseWPF->responseStatus;

                echo "Response: " . $ServiceResponseWPF->application->signature;
                $cert = "6B1198B811715D83148DB4E7FC981A54"; //merchantkey

                $forSign = $application->merchantid . $application->request_id . $application->response_id . $responseStatus->response_code . $responseStatus->response_message . $responseStatus->
                    response_advise . $application->timestamp . $application->rebill_id . $cert;

                $_sign = hash("sha512", $forSign);

                echo "</br>computed:" . $_sign;

                if ($_sign == $ServiceResponseWPF->application->signature) {
                    if ($responseStatus->response_code == "GR001" || $responseStatus->response_code == "GR002") {
                        //SUCCESS TRANSACTION
                        $sales = SalesHeader::where('order_number', $application->request_id);
                        if ($sales) {
                            $sales->update([
                                'status' => 'PAID',
                                'response_code' => $body,
                                'delivery_status' => 'Processing Stock'
                            ]);
                        }
                    } else {
                        //FAILED TRANSACTION
                    }
                } else {
                    echo "</br>INVALID SIGNATURE";
                }
            }
        }
        catch(Exception $ex)
        {echo $ex->getMessage();}
    }

    public function get_percentage($rank,$data){
        $rank = strtoupper($rank);
        //percentage data
            if($rank == 'WARRIOR'){
                switch ($data) {
                    case "retail_income":
                        return 9;
                        break;
                    case "residual_income":
                        return 1.25;
                        break;
                    case "rewards":
                        return 0.75;
                        break;
                    case "rank_advancement_bonus":
                        return 1;
                        break;
                    case "rebate_sales_bonus":
                        return 1.125;
                        break;
                    case "rainmaker_achievement_bonus":
                        return 1;
                        break;
                    case "regents_circle_bonus":
                        return 0.875;
                        break;
                    case "royal_crown_bonus":
                        return 0.1;
                        break;
                    case "replication_premium_incentive":
                        return 0.15;
                        break;
                    default:
                        return 0;
                }
            }
            elseif($rank == 'RANGER'){
                switch ($data) {
                    case "retail_income":
                        return 10;
                        break;
                    case "residual_income":
                        return 2.25;
                        break;
                    case "rewards":
                        return 0.75;
                        break;
                    case "rank_advancement_bonus":
                        return 1;
                        break;
                    case "rebate_sales_bonus":
                        return 1.125;
                        break;
                    case "rainmaker_achievement_bonus":
                        return 1;
                        break;
                    case "regents_circle_bonus":
                        return 0.875;
                        break;
                    case "royal_crown_bonus":
                        return 0.1;
                        break;
                    case "replication_premium_incentive":
                        return 0.15;
                        break;
                    default:
                        return 0;
                }
            }
            elseif($rank == 'ELITE RANGER'){
                switch ($data) {
                    case "retail_income":
                        return 11;
                        break;
                    case "residual_income":
                        return 3;
                        break;
                    case "rewards":
                        return 0.75;
                        break;
                    case "rank_advancement_bonus":
                        return 1;
                        break;
                    case "rebate_sales_bonus":
                        return 1.125;
                        break;
                    case "rainmaker_achievement_bonus":
                        return 1;
                        break;
                    case "regents_circle_bonus":
                        return 0.875;
                        break;
                    case "royal_crown_bonus":
                        return 0.1;
                        break;
                    case "replication_premium_incentive":
                        return 0.15;
                        break;
                    default:
                        return 0;
                }
            }
            elseif($rank == 'MASTER'){
                switch ($data) {
                    case "retail_income":
                        return 12;
                        break;
                    case "residual_income":
                        return 3.5;
                        break;
                    case "rewards":
                        return 0.75;
                        break;
                    case "rank_advancement_bonus":
                        return 1;
                        break;
                    case "rebate_sales_bonus":
                        return 1.125;
                        break;
                    case "rainmaker_achievement_bonus":
                        return 1;
                        break;
                    case "regents_circle_bonus":
                        return 0.875;
                        break;
                    case "royal_crown_bonus":
                        return 0.1;
                        break;
                    case "replication_premium_incentive":
                        return 0.15;
                        break;
                    default:
                        return 0;
                }
            }
            elseif($rank == 'GRAND MASTER'){
                switch ($data) {
                    case "retail_income":
                        return 13;
                        break;
                    case "residual_income":
                        return 4.25;
                        break;
                    case "rewards":
                        return 0.75;
                        break;
                    case "rank_advancement_bonus":
                        return 1;
                        break;
                    case "rebate_sales_bonus":
                        return 1.125;
                        break;
                    case "rainmaker_achievement_bonus":
                        return 1;
                        break;
                    case "regents_circle_bonus":
                        return 0.875;
                        break;
                    case "royal_crown_bonus":
                        return 0.1;
                        break;
                    case "replication_premium_incentive":
                        return 0.15;
                        break;
                    default:
                        return 0;
                }
            }
            elseif($rank == 'LEGEND'){
                switch ($data) {
                    case "retail_income":
                        return 14;
                        break;
                    case "residual_income":
                        return 4.75;
                        break;
                    case "rewards":
                        return 0.75;
                        break;
                    case "rank_advancement_bonus":
                        return 1;
                        break;
                    case "rebate_sales_bonus":
                        return 1.125;
                        break;
                    case "rainmaker_achievement_bonus":
                        return 1;
                        break;
                    case "regents_circle_bonus":
                        return 0.875;
                        break;
                    case "royal_crown_bonus":
                        return 0.1;
                        break;
                    case "replication_premium_incentive":
                        return 0.15;
                        break;
                    default:
                        return 0;
                }
            }
            elseif($rank == 'GRAND LEGEND'){
                switch ($data) {
                    case "retail_income":
                        return 15;
                        break;
                    case "residual_income":
                        return 5;
                        break;
                    case "rewards":
                        return 0.75;
                        break;
                    case "rank_advancement_bonus":
                        return 1;
                        break;
                    case "rebate_sales_bonus":
                        return 1.125;
                        break;
                    case "rainmaker_achievement_bonus":
                        return 1;
                        break;
                    case "regents_circle_bonus":
                        return 0.875;
                        break;
                    case "royal_crown_bonus":
                        return 0.1;
                        break;
                    case "replication_premium_incentive":
                        return 0.15;
                        break;
                    default:
                        return 0;
                }
            }
        //end percentage data
    }

    public function retail_income($data){

        $percentage = $this->get_percentage($data['rank'],'retail_income');

        if($data['purchased_count'] > 1){
            $value =  ( ($percentage/100) * $data['net_price']);
        }
        else{
            $value = 0;
        }

        return $value;
    }

    public function retail_income_from_downline($data){

        $percentage = $this->get_percentage($data['rank'],'retail_income');

        if($data['purchased_count'] == 1){
            $value =  ( ($percentage/100) * $data['net_price']);
        }
        else{
            $value = 0;
        }

        return $value;
    }

    public function retail_income_sponsor($data){

        $percentage = $this->get_percentage($data['rank'],'retail_income');

        if($data['purchased_count'] == 1){
            $value =  ( ($percentage/100) * $data['net_price']);
        }
        else{
            $value = 0;
        }

        return $value;
    }

    public function residual_income($data){

        $percentage = $this->get_percentage($data['rank'],'residual_income');

        $value =  ( ($percentage/100) * $data['net_price']);

        return $value;
    }

    public function rewards($data){

        $percentage = $this->get_percentage($data['rank'],'rewards');

        $value =  ( ($percentage/100) * $data['net_price']);

        return $value;
    }

    public function rank_advancement_bonus($data){

        $percentage = $this->get_percentage($data['rank'],'rank_advancement_bonus');

        $value =  ( ($percentage/100) * $data['net_price']);

        return $value;
    }

    public function rebate_sales_bonus($data){

        $percentage = $this->get_percentage($data['rank'],'rebate_sales_bonus');

        $value =  ( ($percentage/100) * $data['net_price']);

        return $value;
    }

    public function rainmaker_achievement_bonus($data){

        $percentage = $this->get_percentage($data['rank'],'rainmaker_achievement_bonus');

        $value =  ( ($percentage/100) * $data['net_price']);

        return $value;
    }

    public function regents_circle_bonus($data){

        $percentage = $this->get_percentage($data['rank'],'regents_circle_bonus');

        $value =  ( ($percentage/100) * $data['net_price']);

        return $value;
    }

    public function royal_crown_bonus($data){

        $percentage = $this->get_percentage($data['rank'],'royal_crown_bonus');

        $value =  ( ($percentage/100) * $data['net_price']);

        return $value;
    }

    public function replication_premium_incentive($data){

        $percentage = $this->get_percentage($data['rank'],'replication_premium_incentive');

        $value =  ( ($percentage/100) * $data['net_price']);

        return $value;
    }
}
