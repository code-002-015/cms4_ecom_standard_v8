<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MediaAccounts extends Model
{
    public $table = 'social_media';

    protected $fillable = [ 'name', 'media_account', 'user_id',];

    public $timestamps = false;
}
