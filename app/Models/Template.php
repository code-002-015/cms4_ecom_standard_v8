<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Template extends Model
{
    use HasFactory, SoftDeletes;

    public $table = 'templates';
    protected $timestamp = true;
    protected $fillable = [
        'category_id',
        'name',
        'desc',
        'tags',
        'url',
        'thumbnail_url',
        'main_banner_width',
        'main_banner_height',
        'sub_banner_width',
        'sub_banner_height',
        'news_banner_width',
        'news_banner_height',
        'user_logo_width',
        'user_logo_height',
        'news_thumbnail_width',
        'news_thumbnail_height',
        'status',
        'user_id',
    ];

    public function category()
    {
        return $this->belongsTo(TemplateCategory::class);
    }
}
