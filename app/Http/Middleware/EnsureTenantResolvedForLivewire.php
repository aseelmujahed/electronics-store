<?php

namespace App\Http\Middleware;

use Closure;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

class EnsureTenantResolvedForLivewire
{
    public function handle($request, Closure $next)
    {
        $host = $request->getHost();
        if ($host === '127.0.0.1' || $host === '/super-admin') {
            return $next($request);
        }

        app(InitializeTenancyByDomain::class)->handle($request, function () {});
        app(PreventAccessFromCentralDomains::class)->handle($request, function () {});

        return $next($request);
    }
}
