<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailRecipient extends Model
{
    protected $fillable = ['name', 'email'];

    public static function email_list()
    {
        return EmailRecipient::select('email')->pluck('email')->toArray();
    }

    public static function email_list_str()
    {
        return implode(',', self::email_list());
    }
}
