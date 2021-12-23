<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

use App\Models\Coupon;
use App\Models\SalesHeader;

class CouponSale extends Model
{
	protected $table = "coupon_sales";
    protected $fillable = [ 'customer_id', 'coupon_id', 'coupon_code', 'sales_header_id', 'order_status','product_id','discount','is_sfee'];
    public $timestamps = true;

    public function details()
    {
    	return $this->belongsTo(Coupon::class,'coupon_id');
    }

    public function sales_details()
    {
    	return $this->belongsTo(SalesHeader::class,'sales_header_id');
    }

    public static function total_product_discount($orderid,$productid,$qty,$price)
    {
        $coupons = CouponSale::where('sales_header_id',$orderid)->where('product_id',$productid);

        if($coupons->count()){
            $coupon = $coupons->first();

            if(isset($coupon->details->amount)){
                $discount = $coupon->details->amount*$coupons->count();
            }

            if(isset($coupon->details->percentage)){
                $percent = $coupon->details->percentage/100;
                $discount = ($price*$percent)*$coupons->count();
            }
        } else {
            $discount = 0;
        }

        return number_format($discount,2);
    }

    public static function total_discount_amount($orderid)
    {
        $coupons = CouponSale::where('sales_header_id',$orderid)->get();

        $discount = 0;
        foreach($coupons as $coupon){
            if($coupon->details->amount_discount_type == 1){
                if(isset($coupon->details->amount)){
                    $discount += $coupon->details->amount;
                }

                if(isset($coupon->details->percentage)){
                    $subtotal = $coupon->sales_details->gross_amount-$coupon->sales_details->delivery_fee_amount;

                    $percent = $coupon->details->percentage/100;
                    $discount += ($subtotal*$percent)*$coupons->count();
                }
            }
        }

        return $discount;
    }

    public static function total_discount_delivery($orderid)
    {
        $coupons = CouponSale::where('sales_header_id',$orderid)->get();

        $discount = 0;
        foreach($coupons as $coupon){
            if(isset($coupon->details->location)){
                if($coupon->details->location_discount_type == 'full'){
                    $sales = SalesHeader::find($orderid);

                    $discount += $sales->delivery_fee_amount;

                } else {
                    $discount += $coupon->details->location_discount_amount;
                }
            }
        }

        return $discount;
    }
}
