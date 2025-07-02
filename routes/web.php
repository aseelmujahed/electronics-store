<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

use App\Livewire\ProductList;

Route::get('/dashboard', ProductList::class)->middleware(['auth', 'verified'])->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

use App\Livewire\UserCart;

Route::get('/cart', UserCart::class)->middleware('auth')->name('cart');

require __DIR__.'/auth.php';