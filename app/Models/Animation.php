<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Animation extends Model
{
    protected $table = 'animations';
    protected $fillable = ['name', 'value'];

}
