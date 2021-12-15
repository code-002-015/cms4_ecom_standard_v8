<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Contributor
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
        if(Auth::check() && Auth::user()->role_id == '3'){
            // 3 for contributor role
            return $next($request);
        }
        else {
            return view('403','Unauthorized Page Access');
        }
    }
}
