<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Keep this file as the central route entry point.
// Domain-specific routes belong in customer.php and partner.php.
require __DIR__.'/customer.php';
require __DIR__.'/partner.php';
