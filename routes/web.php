<?php

use App\Livewire\Sales;
use App\Livewire\Products;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::middleware(['auth'])->group(function () {
    Route::get('products', Products::class)->name('products');
    Route::get('sales', Sales::class)->name('sales');
});

require __DIR__ . '/auth.php';
