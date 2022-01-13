<?php


namespace App\Helpers;

use App\Models\Cart;
use App\Models\CouponCart;
use App\Models\Coupon;
use App\Helpers\Setting;
use Auth;

class PaynamicsHelper
{

    public static function payNow($requestId, $member, $cart, $totalAmount, $url, $withMembershipFee = false, $deliveryFee = 0, $total_discount)
    {
        $merchant = Setting::paynamics_merchant();
        $allowed_payments = strtoupper(Setting::info()->accepted_payments);        
        $_amount = number_format($totalAmount, 2, '.', '');
        //$_amount = $totalAmount;

        $itemXml = "";
        $product_total_discount = 0;
        $product_subtotal = 0;
        foreach ($cart as $product) {
            $price = number_format($product->product->discountedprice, 2, '.', '');
            $pqty = (int)$product->qty;
            $itemXml = $itemXml . "<Items><itemname>{$product->product->name}</itemname><quantity>{$pqty}</quantity><amount>{$price}</amount></Items>";
        }

        if($total_discount > 0){
            $itemXml = $itemXml . "<Items><itemname>Order Discount</itemname><quantity>1</quantity><amount>-{$total_discount}</amount></Items>";    
        }


        $coupons = CouponCart::where('customer_id',Auth::id())->get();
        $totalDiscount = 0;
        $totalSfDiscount = 0;
        // $sfDiscount = 0;
        foreach($coupons as $coupon){
            $c = Coupon::find($coupon->coupon_id);

            if(isset($c->location)){
                if($c->location_discount_type == 'partial'){
                    $sfDiscount = number_format($c->location_discount_amount,2,'.','');
                } else {
                    $sfDiscount = $deliveryFee;
                }
                $totalSfDiscount += $sfDiscount;
            }  
        }

        if ($deliveryFee > 0) {
            $deliveryFee = number_format($deliveryFee, 2, '.', '');
            $itemXml = $itemXml . "<Items><itemname>Delivery Fee</itemname><quantity>1</quantity><amount>{$deliveryFee}</amount></Items>";
        }

        if($totalSfDiscount > 0){
            $itemXml = $itemXml . "<Items><itemname>Delivery Discount</itemname><quantity>1</quantity><amount>-{$totalSfDiscount}</amount></Items>";    
        }

        
        
        
        $_mid = $merchant['id']; //<-- your merchant id
        $_requestid = $requestId;
        $_ipaddress = (isset($_SERVER['SERVER_ADDR'])) ? $_SERVER['SERVER_ADDR'] : $_SERVER['SERVER_NAME'];
        $_noturl = $url['notification']; //<-- your notification url where notification of final status will be sent upon loading the transaction receipt page
        $_resurl = $url['result']; // route('cart.front.checkout_completed'); //<-- your response url where transaction will be redirected after pressing continue button
        $_cancel_url = $url['cancel']; //<-- your cancel url where transaction will be redirected if transaction is cancelled
        $_mtac_url = url('/'); //<-- your terms and condition url
        $_fname = $member->firstname;
        $_mname = "";
        $_lname = $member->lastname;
        $_addr1 = $member->address_street;
        $_addr2 = "";
        $_city = $member->address_city;
        $_state = $member->address_municipality;
        $_country = "Philippines";
        $_zip = $member->address_zip;
        $_sec3d = "try3d";
        $_email = $member->email;
        $_phone = $member->phone;
        $_mobile = $member->mobile;
        $_clientip = $_SERVER['REMOTE_ADDR'];
        $_currency = "PHP";
        $_trxtype = "sale";
        $_ptype = $allowed_payments; // <-- if empty, all payment types available for the merchant will be shown (BN,PP,GC)
        $_mlogo_url = asset('images/logo.png'); // <-- url of the logo to appear on the wpf page
        $forSign = $_mid . $_requestid . $_ipaddress . $_noturl . $_resurl . $_fname . $_lname . $_mname . $_addr1 . $_addr2 . $_city . $_state . $_country . $_zip . $_email . $_phone . $_clientip . $_amount . $_currency . $_sec3d;
        $cert = $merchant['key']; //<-- your merchant key

        $_sign = hash("sha512", $forSign.$cert);

        $strxml = "";

        $strxml = $strxml . "<?xml version=\"1.0\" encoding=\"utf-8\" ?>";
        $strxml = $strxml . "<Request>";
        $strxml = $strxml . "<orders>";
        $strxml = $strxml . "<items>";
        //$strxml = $strxml . "<Items>";
        $strxml = $strxml . $itemXml;
        //$strxml = $strxml . "</Items>";
        $strxml = $strxml . "</items>";
        $strxml = $strxml . "</orders>";
        $strxml = $strxml . "<mid>" . $_mid . "</mid>";
        $strxml = $strxml . "<request_id>" . $_requestid . "</request_id>";
        $strxml = $strxml . "<ip_address>" . $_ipaddress . "</ip_address>";
        $strxml = $strxml . "<notification_url>" . $_noturl . "</notification_url>";
        $strxml = $strxml . "<response_url>" . $_resurl . "</response_url>";
        $strxml = $strxml . "<cancel_url>" . $_cancel_url . "</cancel_url>";
        $strxml = $strxml . "<mtac_url>" . $_mtac_url . "</mtac_url>";
        $strxml = $strxml . "<descriptor_note>' '</descriptor_note>";
        $strxml = $strxml . "<fname>" . $_fname . "</fname>";
        $strxml = $strxml . "<lname>" . $_lname . "</lname>";
        $strxml = $strxml . "<mname>" . $_mname . "</mname>";
        $strxml = $strxml . "<address1>" . $_addr1 . "</address1>";
        $strxml = $strxml . "<address2>" . $_addr2 . "</address2>";
        $strxml = $strxml . "<city>" . $_city . "</city>";
        $strxml = $strxml . "<state>" . $_state . "</state>";
        $strxml = $strxml . "<country>" . $_country . "</country>";
        $strxml = $strxml . "<zip>" . $_zip . "</zip>";
        $strxml = $strxml . "<secure3d>" . $_sec3d . "</secure3d>";
        $strxml = $strxml . "<trxtype>sale</trxtype>";
        $strxml = $strxml . "<email>" . $_email . "</email>";
        $strxml = $strxml . "<phone>" . $_phone . "</phone>";
        $strxml = $strxml . "<mobile>" . $_mobile . "</mobile>";
        $strxml = $strxml . "<client_ip>" . $_clientip . "</client_ip>";
        $strxml = $strxml . "<amount>" . $_amount . "</amount>";
        $strxml = $strxml . "<currency>" . $_currency . "</currency>";
        $strxml = $strxml . "<mlogo_url>" . $_mlogo_url . "</mlogo_url>";
        $strxml = $strxml . "<pmethod>" . $_ptype . "</pmethod>";
        $strxml = $strxml . "<signature>" . $_sign . "</signature>";
        $strxml = $strxml . "</Request>";
        logger($strxml);
        return base64_encode($strxml);
    }
}
