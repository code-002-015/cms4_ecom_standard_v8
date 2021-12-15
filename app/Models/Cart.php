<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{

    protected $table = 'ecommerce_shopping_cart';
    protected $fillable = ['user_id', 'product_id', 'price', 'qty'];
    const GUEST_CART = 'cart';
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo('\App\Models\Product','product_id');
    }

    public function getItemTotalPriceAttribute()
    {
        return ($this->product->discountedprice * $this->qty);
    }

    public static function total_cart()
    {
        if (\Auth::check()) {
            $cart = Cart::where('user_id', auth()->id())->get();
        } else {
            $cart = session(Cart::GUEST_CART, []);
        }       

        return self::total_price_of_cart($cart);
    }

    public static function total_items_of_guest_cart()
    {
        $cart = session(Cart::GUEST_CART, []);

        return self::total_items_of_cart($cart);
    }

    public static function total_items_of_auth_cart()
    {
        $cart = Cart::where('user_id', auth()->id())->get();

        return self::total_items_of_cart($cart);
    }

    private static function total_items_of_cart($cart)
    {
        $qty = 0;
        foreach ($cart as $order) {
            $qty += $order->qty;
        }

        return $qty;
    }

    private static function total_price_of_cart($cart)
    {
        $qty = 0;
        foreach ($cart as $order) {
            $qty += $order->qty * $order->price;
        }

        return $qty;
    }

    public static function is_product_on_cart($product_id){
        if (\Auth::check()) {
            $cart = Cart::where('user_id', auth()->id())->get();
        } else {
            $cart = session(Cart::GUEST_CART, []);
        } 
        $qty = 0;
        foreach($cart as $c){
            if($c->product_id == $product_id){
                $qty = $c->qty;
            }
        }
        return $qty;
        
    }

    public static function on_cart($productid)
    {
        $cart = Cart::where('user_id', auth()->id())->where('product_id',$productid)->count();

        return $cart;
    }

}
