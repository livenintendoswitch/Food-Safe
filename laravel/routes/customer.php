<?php

use App\Http\Controllers\Customer\ListingController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/discovery', [ListingController::class, 'home'])
        ->name('customer.discovery.home');

    Route::get('/discovery/listings', [ListingController::class, 'index'])
        ->name('customer.discovery.listings');

    Route::get('/discovery/listings/{listing}', [ListingController::class, 'show'])
        ->name('customer.discovery.show');
});
