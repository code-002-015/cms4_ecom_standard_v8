<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ViewPermissions extends Model
{
    protected $table = 'view_access_permission_per_role';

    public static function check_permission($user_id,$action)
    {
        if (auth()->user()->is_an_admin()) {
            return 1;
        }

        $rolepermission = ViewPermissions::where('role',$user_id)->first();

        $array_permissions = [];

        if ($rolepermission) {
            $array_permissions = explode('|', $rolepermission->permissions);
        }

        if(in_array($action, $array_permissions)){
            return 1;
        } else {
            return 0;
        }
    }
}
