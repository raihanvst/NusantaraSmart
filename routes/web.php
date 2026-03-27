<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\ShopController; 

require __DIR__.'/auth.php';

// Home
Route::get('/', function () {
    return redirect()->route('shop.index');
});

// =============================================
// CUSTOMER / SHOP ROUTES (publik)
// =============================================
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/{product:slug}', [ShopController::class, 'show'])->name('shop.show');

// Placeholder untuk routes yang dibuat nanti
Route::middleware(['auth'])->group(function () {
    Route::get('/cart', function () { return 'Cart coming soon'; })->name('cart.index');
    Route::get('/orders', function () { return 'Orders coming soon'; })->name('orders.index');
});

// =============================================
// ADMIN ROUTES
// =============================================
Route::middleware(['auth', 'isAdmin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
});