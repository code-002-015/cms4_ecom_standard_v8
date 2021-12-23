<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CouponCartDiscount extends Model
{
    protected $table = 'coupon_cart_temp_discount';
    protected $fillable = [ 'customer_id','coupon_discount'];
    public $timestamps = false;
}
