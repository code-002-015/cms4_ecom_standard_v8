<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use Auth;

class CustomerWishlist extends Model
{
    public $table = 'customer_wishlist';
    public $fillable = ['product_id','customer_id'];
    protected $timestamp = true;

    public function customer_details()
    {
    	return $this->belongsTo('\App\User','customer_id');
    }

    // public static function product_wishlist($id)
    // {
    // 	$count = CustomerWishlist::where('customer_id',Auth::id())->where('product_id',$id)->count();

    // 	return $count;
    // }

    public static function is_wishlist($id)
    {
        $count = CustomerWishlist::where('customer_id',Auth::id())->where('product_id',$id)->count();

        return $count;
    }


    public function product_details()
    {
        return $this->belongsTo('\App\Models\Product','product_id');
    }

    public static function wishlist_available()
    {
        $products = CustomerWishlist::where('customer_id',Auth::id())->get();

        $counter = 0;
        foreach($products as $prod){
            if($prod->product_details->maxpurchase > 0){
                $counter++;
            }
        }

        return $counter;
    }

    public static function product_exist($productid)
    {
        $count = CustomerWishlist::where('product_id',$productid)->count();

        return $count;
    }
}
