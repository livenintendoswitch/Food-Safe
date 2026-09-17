<?php

use Illuminate\Support\Facades\Route;

// Partner routes. Backend 1 owns this file.
Route::middleware('auth')->group(function () {
    // Route::get('/partner/listings', [ListingController::class, 'index'])->name('partner.listings');
});
