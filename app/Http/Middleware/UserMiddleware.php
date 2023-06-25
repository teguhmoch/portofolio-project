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

        if ($session->status = 'inactive') {
            // $request->session()->flush();
            return redirect()->route('user.login')->with('error', 'Your account status inactive, please contact admin to actived your account !');
        }

        return $next($request);
    }
}
