<?php

use App\Livewire\Sales;
use App\Livewire\Products;
use App\Livewire\JournalEntries;
use App\Livewire\FinancialReports;
use Illuminate\Support\Facades\Route;

// Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::middleware(['auth'])->group(function () {
    Route::get('products', Products::class)->name('products');
    Route::get('sales', Sales::class)->name('sales');
    Route::get('journal', JournalEntries::class)->name('journal');
    Route::get('reports', FinancialReports::class)->name('reports');
});

require __DIR__ . '/auth.php';
