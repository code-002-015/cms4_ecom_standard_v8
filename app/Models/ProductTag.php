<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductTag extends Model
{    
    public $table = 'product_tags';
    protected $fillable = [ 'product_id', 'tag', 'created_by' ];

    public static function tags($id)
    {
        $datas = ProductTag::where('product_id',$id)->get();

        $tags = "";

        foreach($datas as $data)
        {
            $tags .= $data->tag.',';
        }
        
        return $tags;
    }
}
