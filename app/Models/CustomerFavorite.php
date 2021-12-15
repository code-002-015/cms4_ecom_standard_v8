<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;

class CustomerFavorite extends Model
{
    public $table = 'customer_favorites';
    public $fillable = ['product_id','customer_id'];
    protected $timestamp = true;

    public function customer_details()
    {
    	return $this->belongsTo('\App\Models\User','customer_id');
    }

    public static function is_favorite($id)
    {
    	$count = CustomerFavorite::where('customer_id',Auth::id())->where('product_id',$id)->count();

    	return $count;
    }

    public function product_details()
    {
        return $this->belongsTo('\App\Models\Product','product_id');
    }
}
