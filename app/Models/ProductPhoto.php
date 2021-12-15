<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ProductPhoto extends Model
{
    public $table = 'product_photos';
    protected $fillable = [ 'product_id', 'name', 'description', 'status', 'is_primary', 'path', 'created_by' ];

    public function file_name()
    {
        $path = explode('/', $this->path);
        $nameIndex = count($path) - 1;
        if ($nameIndex < 0)
            return '';

        return $path[$nameIndex];
    }

    public function storage_path()
    {
        return asset('storage/products/'.$this->path);
    }
}
