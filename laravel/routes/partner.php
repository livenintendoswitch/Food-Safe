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