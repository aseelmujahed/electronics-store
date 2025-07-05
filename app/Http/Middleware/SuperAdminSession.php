<?php

namespace App\Http\Middleware;

use Closure;

class SuperAdminSession
{
    public function handle($request, Closure $next)
    {
        if (!session('is_super_admin')) {
            return redirect()->route('superadmin.login.form');
        }
        return $next($request);
    }
}
