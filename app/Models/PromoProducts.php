<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromoProducts extends Model
{
    public $table = 'promo_products';
    protected $fillable = ['promo_id', 'product_id', 'user_id'];
 	public $timestamps = true;

 	public function details()
 	{
 		return $this->belongsTo('\App\Models\Product','product_id','id');
 	}

 	public function promo_details()
 	{
 		return $this->belongsTo('\App\Models\Promo','promo_id')->withTrashed();
 	}

 	public static function is_promo($promoid,$productid)
    {
        $count = PromoProducts::where('promo_id',$promoid)->where('product_id',$productid)->count();

        return $count;
    }
}
