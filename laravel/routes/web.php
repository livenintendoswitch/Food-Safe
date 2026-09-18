<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('customer.index');
})->name('home');

Route::get('/browse', function () {
    return view('customer.browse');
})->name('browse');

Route::middleware('auth')->get('/dashboard', function () {
    return view('customer.index');
})->name('dashboard');

require __DIR__.'/auth.php';
require __DIR__.'/customer.php';
require __DIR__.'/partner.php';