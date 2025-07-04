<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    $stores = DB::table('tenants')->get(['id']);
    return view('market-home', compact('stores'));
});

require __DIR__.'/auth.php';