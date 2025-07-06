<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use App\Livewire\ProductList;
use App\Livewire\UserCart;
    use App\Http\Controllers\DeliveryController;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,

])->group(function () {

    Route::view('/welcome', 'welcome')->name('tenant.home');

    Route::view('profile', 'profile')
        ->middleware(['auth'])
        ->name('tenant.profile');

    Route::get('/dashboard', ProductList::class)
        ->middleware(['auth', 'verified'])
        ->name('dashboard');

    Route::get('/cart', UserCart::class)
        ->middleware('auth')
        ->name('tenant.cart');

    Route::get('/debug-tenant', function () {
        return 'Current tenant: ' . (tenant('id') ?? 'none');
    });

    Route::get('/my-orders', \App\Livewire\MyOrders::class)->name('my.orders');

});

Route::middleware(['auth', 'verified', 'admin'])->group(function () {
    Route::get('/admin/dashboard', \App\Livewire\Admin\Dashboard::class)->name('admin.dashboard');
});
