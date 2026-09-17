<?php
use App\Http\Controllers\Customer\PickupController;
use App\Http\Controllers\Customer\PaymentController;
use App\Http\Controllers\Customer\OrderController;
use Illuminate\Support\Facades\Route;

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