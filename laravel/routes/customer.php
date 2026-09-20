<?php

use App\Http\Controllers\Customer\ListingController;
use App\Http\Controllers\Customer\OrderController;
use App\Http\Controllers\Customer\PaymentController;
use App\Http\Controllers\Customer\PickupController;
use Illuminate\Support\Facades\Route;

Route::prefix('discovery')
    ->name('customer.discovery.')
    ->group(function () {
        Route::get('/', [ListingController::class, 'home'])
            ->name('home');

        Route::get('/listings', [ListingController::class, 'index'])
            ->name('listings');

        Route::get('/listings/{listing}', [ListingController::class, 'show'])
            ->name('show');
    });

Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])
        ->name('customer.orders');

    Route::get('/orders/{order}', [OrderController::class, 'show'])
        ->name('customer.orders.show');

    Route::post('/orders', [OrderController::class, 'store'])
        ->name('customer.orders.store');

    Route::post('/orders/{order}/payment', [PaymentController::class, 'store'])
        ->name('customer.orders.payment');

    Route::get('/orders/{order}/pickup', [PickupController::class, 'show'])
        ->name('customer.orders.pickup');
});