<?php

use Illuminate\Support\Facades\Route;

// Customer routes. Backend 2 owns this file.
Route::middleware('auth')->group(function () {
    // Route::get('/orders', [OrderController::class, 'index'])->name('customer.orders');
});
