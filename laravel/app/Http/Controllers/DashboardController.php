<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController
{
    public function __invoke(): View
    {
        $user = Auth::user();

        if ($user->role === 'partner') {
            $restaurant = Restaurant::query()
                ->where('owner_id', $user->id)
                ->first();

            return view('partner.dashboard', compact('restaurant'));
        }

        return view('customer.index');
    }
}