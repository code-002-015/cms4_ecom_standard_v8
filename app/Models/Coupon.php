<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Auth;
use Carbon\Carbon;

use App\Models\Product;
use App\Models\CouponSale;

use App\User;


class Coupon extends Model
{
	use SoftDeletes;

    protected $fillable = [ 'coupon_code', 'name', 'description', 'terms_and_conditions', 'activation_type', 'customer_scope', 'scope_customer_id', 'scope_subscriber_group_id', 'area', 'location','location_discount_type','location_discount_amount', 'amount', 'percentage', 'free_product_id', 'status', 'start_date', 'end_date', 'start_time', 'end_time', 'event_name', 'event_date', 'repeat_annually', 'purchase_product_id', 'purchase_product_cat_id', 'purchase_product_brand', 'purchase_amount', 'purchase_amount_type', 'amount_discount_type', 'purchase_qty', 'purchase_qty_type', 'purchase_combination_counter','purchase_combination', 'activity_type', 'customer_limit', 'usage_limit', 'usage_limit_no', 'combination', 'availability', 'user_id','product_discount', 'discount_product_id'];
    
    public $timestamps = true;

    public static function generate_unique_code()
    {
        $randomString = self::generate_random_string();
        $couponCode = Coupon::where('coupon_code', $randomString)->get();
        while ($couponCode->count()) {
            $randomString = self::generate_random_string();
            $couponCode = Coupon::where('coupon_code', $randomString)->first();
        }

        return $randomString;
    }

    private static function generate_random_string($length = 8) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public static function coupon_total_usage($couponid)
    {
        $total = CouponSale::where('coupon_id',$couponid)->count();

        return $total;
    }

    public static function coupon_usage($couponid)
    {
        $coupon = Coupon::find($couponid);
        $totalUsage = CouponSale::where('coupon_id',$couponid)->where('customer_id',Auth::id())->count();

        if(isset($coupon->usage_limit)){
            if($coupon->usage_limit == 'single_use'){
                if($totalUsage == 1){
                    $usability = 0;
                } else {
                    $usability = 1;
                }
            }

            if($coupon->usage_limit == 'multiple_use'){
                if($totalUsage <= $coupon->usage_limit_no){
                    $usability = 1;
                } else {
                    $usability = 0;
                }
            }
        } else {
            $usability = 1;
        }
        
        return $usability;
    }

    public static function collectible_usage($couponid)
    {
        $totalUsage = CouponSale::where('coupon_id',$couponid)->where('customer_id',Auth::id())->count();

        return $totalUsage;
    }

    public static function couponPurchaseValue($purchase_field,$purchase_type,$purchase_value,$amount_type,$operator)
    {
        $coupons = 
            Coupon::where('status','ACTIVE')
            ->where('availability',1)
            ->where('purchase_combination_counter',1)
            ->where('activation_type','auto')
            ->whereNotNull($purchase_field)->where($purchase_type,$amount_type)->where($purchase_field,$operator,$purchase_value)->get();

        return $coupons;
    }

    public static function purchaseMaxValue($purchase_field,$purchase_type,$purchase_value)
    {
        $coupons = 
            Coupon::where('status','ACTIVE')
            ->where('availability',1)
            ->where('purchase_combination_counter',1)
            ->where('activation_type','auto')
            ->whereNotNull($purchase_field)->where($purchase_type,'max')->where($purchase_field,'>=',$purchase_value)->get();

        return $coupons;
    }
}
