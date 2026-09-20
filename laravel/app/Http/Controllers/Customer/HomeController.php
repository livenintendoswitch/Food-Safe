<?php

namespace App\Http\Controllers\Customer;

use Illuminate\View\View;

class HomeController
{
    public function index(): View
    {
        return view('customer.index');
    }
}