<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    $stores = DB::table('tenants')->get(['id']);
    return view('market-home', compact('stores'));
});

use App\Http\Controllers\SuperAdminController;
use App\Livewire\SuperAdminDashboard;

Route::get('/super-admin/login', [SuperAdminController::class, 'loginForm'])->name('superadmin.login.form');
Route::post('/super-admin/login', [SuperAdminController::class, 'login'])->name('superadmin.login');
Route::post('/super-admin/logout', [SuperAdminController::class, 'logout'])->name('superadmin.logout');

Route::middleware(['superadmin.session'])->get('/super-admin', SuperAdminDashboard::class)->name('superadmin.dashboard');

Route::post('/change-language', function () {
    $locale = request('locale');
    if (in_array($locale, ['en', 'ar'])) {
        session(['locale' => $locale]);
        app()->setLocale($locale);
    }
    return back();
})->name('change.language');

use App\Http\Controllers\DeliveryCompanyAuthController;

Route::get('/delivery-company/login', [DeliveryCompanyAuthController::class, 'showLoginForm'])->name('delivery-company.login');
Route::post('/delivery-company/login', [DeliveryCompanyAuthController::class, 'login']);
Route::post('/delivery-company/logout', [DeliveryCompanyAuthController::class, 'logout'])->name('delivery-company.logout');

Route::middleware('deliverycompany.auth')->group(function () {
    Route::get('/delivery-company', \App\Livewire\DeliveryCompanyOrders::class)->name('delivery-company.dashboard');
});

require __DIR__.'/auth.php';
