<?php

namespace App\Http\Middleware;
use Closure;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class UserMiddleware
{
    
    public function handle($request, Closure $next)
    {
        $session = session()->get('user');

        if ($session == null) {
            return redirect()->route('user.login')->with('error', 'Please login first.');
        }
        return $next($request);
    }
}
