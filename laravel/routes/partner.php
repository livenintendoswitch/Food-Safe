<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Partner\RestaurantController;
use App\Http\Controllers\Partner\ListingController;

// This automatically applies the /partner/ URL prefix and the "partner." route name prefix
Route::prefix('partner')
    ->name('partner.')
    ->middleware(['web', 'auth']) // Protects the routes so only logged-in users can access them
    ->group(function () {
        
        // This single line generates all 7 standard routes (index, create, store, edit, update, destroy, show)
        Route::resource('restaurants', RestaurantController::class);
        Route::resource('listings', ListingController::class);
        
    });
use App\Http\Controllers\Partner\RestaurantController;
use App\Http\Controllers\Partner\ListingController;
use App\Http\Controllers\Partner\OrderController;
// This automatically applies the /partner/ URL prefix and the "partner." route name prefix
Route::prefix('partner')
    ->name('partner.')
    ->middleware(['web', 'auth']) // Protects the routes so only logged-in users can access them
    ->group(function () {
        
        // This single line generates all 7 standard routes (index, create, store, edit, update, destroy, show)
        Route::resource('restaurants', RestaurantController::class);
        Route::resource('listings', ListingController::class);

        Route::middleware('role:partner')->group(function () {
        Route::get('orders', [OrderController::class, 'index'])
            ->name('orders');

        Route::get('orders/{order}', [OrderController::class, 'show'])
            ->name('orders.show');

        Route::post('orders/{order}/pickup', [OrderController::class, 'completePickup'])
            ->name('orders.pickup');
});
        
    });