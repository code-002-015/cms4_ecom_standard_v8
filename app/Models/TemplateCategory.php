<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class TemplateCategory extends Model
{
    use HasFactory, SoftDeletes;

    public $table = 'template_categories';
    protected $timestamp = true;
    protected $fillable = [
        'name',
        'status',
        'user_id',
    ];

    public function templates()
    {
        return $this->hasMany(Template::class, 'category_id');
    }


}
