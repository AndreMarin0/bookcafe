<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleCheckMiddleware
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
        if(Auth::check()){
            $userRole = Auth::user()->role;
            if($userRole == '1'){
                return $next($request);
            } else if($userRole == '0' && $request->routeIs('collections.*')) {
                // allow user with role == 0 to access 'collections' routes
                return $next($request);
            } else {
                return redirect()->back()->with('error', 'Access Denied');
            }
        } else {
            return redirect()->back()->with('error', 'bruh');
        }
        return $next($request);
    }
}
