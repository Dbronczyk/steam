<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class UserMiddleware
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
        if (Auth::guest()){
            return redirect('steam');
        }

        if (!Auth::guest() && Auth::user()->role == 1 || Auth::user()->role == 10) {
            return $next($request);
        }

        return redirect('/');

    }
}
