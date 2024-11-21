<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->is_admin) { // Assuming 'is_admin' is a boolean field in users table
            return $next($request);
        }

        return redirect('/user/dashboard')->with('error', 'Access denied.');
    }
}

