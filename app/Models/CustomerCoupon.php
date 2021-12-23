<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Coupon;

class CustomerCoupon extends Model
{

	protected $table = 'customer_coupons';
    protected $fillable = [ 'coupon_id','customer_id','usage_status','coupon_status'];
    
    public $timestamps = true;

    public function details()
    {
    	return $this->belongsTo(Coupon::class, 'coupon_id');
    }
}
