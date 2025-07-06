<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureDeliveryCompanyAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!session('is_delivery_company')) {
            return redirect()->route('delivery-company.login');
        }
        return $next($request);
    }
}
