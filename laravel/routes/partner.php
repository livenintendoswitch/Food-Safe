<?php

use App\Http\Controllers\Partner\ListingController;
use App\Http\Controllers\Partner\OrderController;
use App\Http\Controllers\Partner\RestaurantController;
use Illuminate\Support\Facades\Route;

Route::prefix('partner')
    ->name('partner.')
    ->middleware(['web', 'auth', 'role:partner'])
    ->group(function () {
        Route::resource('restaurants', RestaurantController::class);
        Route::resource('listings', ListingController::class);

        Route::get('orders', [OrderController::class, 'index'])
            ->name('orders');

        Route::get('orders/{order}', [OrderController::class, 'show'])
            ->name('orders.show');

        Route::post('orders/{order}/pickup', [OrderController::class, 'completePickup'])
            ->name('orders.pickup');
    });