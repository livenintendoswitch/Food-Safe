<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->get('/dashboard', function () {
    return view('customer.index');
})->name('dashboard');

require __DIR__.'/auth.php';
require __DIR__.'/customer.php';
require __DIR__.'/partner.php';