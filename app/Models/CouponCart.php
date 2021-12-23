<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Coupon;

class CouponCart extends Model
{
	protected $table = 'coupon_cart';
    protected $fillable = [ 'coupon_id','product_id','customer_id','total_usage','discount'];
    public $timestamps = true;

    public function details()
    {
    	return $this->belongsTo(Coupon::class, 'coupon_id');
    }

    public function product_details()
    {
        return $this->belongsTo(Product::class,'product_id');
    }

    public static function coupon_exist($id)
    {
    	$count = CouponCart::where('coupon_id',$id)->count();

    	return $count;
    }
}
