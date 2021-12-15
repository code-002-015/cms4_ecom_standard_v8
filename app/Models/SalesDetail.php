<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\User;

class SalesDetail extends Model
{
    use SoftDeletes;

    protected $table = 'ecommerce_sales_details';
    protected $fillable = ['sales_header_id', 'product_id', 'product_name', 'product_category', 'price', 'tax_amount', 'promo_id', 'promo_description', 'discount_amount', 'gross_amount', 'net_amount', 'qty', 'uom', 'created_by'
];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function product()
    {
        return $this->belongsTo('\App\Models\Product');
    }

    public function header()
    {
        return $this->belongsTo('\App\Models\SalesHeader', 'sales_header_id');
    }

    public function category()
    {
        return $this->belongsTo('\App\Models\ProductCategory','product_category');
    }

    public function getItemTotalPriceAttribute()
    {
        return $this->product->discountedprice;
    }

}
