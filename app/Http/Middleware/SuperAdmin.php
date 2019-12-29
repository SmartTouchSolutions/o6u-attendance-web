<?php

namespace App\Http\Middleware;

use Closure;

class SuperAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(\Auth::check()) {
            if(\Auth::user()->type != 'superAdmin') {

                return redirect('/soon');
            }

        } else {
            return redirect('/');
        }

        return $next($request);
    }
}
