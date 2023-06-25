<?php

namespace App\Http\Middleware;
use Closure;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class AdminMiddleware
{
    
    public function handle($request, Closure $next)
    {
        $auth = auth()->user();

        if ($auth == null) {
            return redirect()->route('admin.login')->with('error', 'Please login first.');
        }

        $isAdmin = $auth->roles()->where('title', 'admin')->first();
        $isMaster = $auth->roles()->where('title', 'master')->first();

        if ($isAdmin != null  | $isMaster != null) {
            // abort(403);
            
        } else {
            abort(403);
        }

        return $next($request);
    }
}
