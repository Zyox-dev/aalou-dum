<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StockController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ApprovalOutController;
use App\Http\Controllers\DashboardController;

Route::permanentRedirect('/', '/login');


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'get_profile_data'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update_profile_data'])->name('profile.update');
    Route::post('/profile_password_update', [ProfileController::class, 'update_profile_password'])->name('profile.update_password');
    Route::resource('purchases', PurchaseController::class);
    Route::resource('approval-outs', ApprovalOutController::class);
    Route::get('/stock', [StockController::class, 'index'])->name('stock.index');
});

require __DIR__ . '/auth.php';
