<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication routes
Auth::routes();

// Protected routes (require authentication)
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    
    // Item management
    Route::resource('items', ItemController::class);
    
    // Print inventory report
    Route::get('/inventory/print', [InventoryController::class, 'print'])->name('inventory.print');
});

// Redirect /home to dashboard
Route::get('/home', function () {
    return redirect()->route('dashboard.index');
})->name('home');