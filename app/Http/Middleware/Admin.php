<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Admin
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
        if(\Auth::check()){
            if(\Auth::user()->role_id <> 2){
                // 1 for admin role
                return $next($request);
            }
            else {
                abort('403','Unauthorized page access');
            }
        }
    }
}
