<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\AdminMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web([
            \App\Http\Middleware\EnsureTenantResolvedForLivewire::class,
            \App\Http\Middleware\SetLocale::class,

        ]);
        $middleware->alias([
            'admin' => AdminMiddleware::class,
            'superadmin.session' => \App\Http\Middleware\SuperAdminSession::class,
            'deliverycompany.auth' => \App\Http\Middleware\EnsureDeliveryCompanyAuth::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
