<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use Auth;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user()->is_an_admin()) {
            return $next($request);
        }

        $role_id = Auth::user()->role_id;

        ## check permission
        $rolepermission = ViewPermissions::where('role', $role_id)->first();

        $array_permissions = [];

        if($rolepermission) {
            $array_permissions = explode('|', $rolepermission->permissions);
        }

        if(in_array($permission_name, $array_permissions)){
            return $next($request);
        } else {
            return response('Unauthorized Access. <a href="'.route('dashboard').'">Go back to dashboard</a>', 401);
        }
    }
}
