<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAccessRights
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
        if (auth()->user()->is_an_admin()) {
            return $next($request);
        }

        if (auth()->user()->assign_role->has_permission_to_route($routeId)){
            return $next($request);
        }

        return response()->view('components.unauthorize-access');
    }
}
