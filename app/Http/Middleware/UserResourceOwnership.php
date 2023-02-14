<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserResourceOwnership
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(empty($parameterName=$request->route()->parameterNames)){
            return $next($request);
        }
        $parameterName=$request->route()->parameterNames[0];
        if( $request->route($parameterName)->users_id == Auth::id()){
            return $next($request);
        }
        abort(403);
    }
}
