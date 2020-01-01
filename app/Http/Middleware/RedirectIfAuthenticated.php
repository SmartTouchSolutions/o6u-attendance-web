<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            if($guard != 'student') {
                if(Auth::user()->type == 'superAdmin') {
                    return redirect('/dashboard');
                } else {
                    return redirect('/soon');
                }  
            } elseif($guard == 'student') {
                return redirect('/student/attendance');
            }


        }

        return $next($request);
    }
}
