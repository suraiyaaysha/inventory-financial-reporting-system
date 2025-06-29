<?php

use App\Livewire\Products;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');


Route::get('products', Products::class)
    ->middleware(['auth'])
    ->name('products');

require __DIR__.'/auth.php';
