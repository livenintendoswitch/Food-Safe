<?php

namespace App\Http\Controllers\Customer;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ListingController
{
    public function index(Request $request): View
    {
        // Combined logic: Checks both ACTIVE status and 'stock' column
        $listings = Listing::with('restaurant')
            ->where('status', 'ACTIVE')
            ->where('stock', '>', 0)
            ->latest()
            ->get();

        // Points to Frontend 1's flattened view
        return view('customer.browse', compact('listings'));
    }

    public function show(Listing $listing): View
    {
        $listing->load('restaurant');

        // Combined logic: Protects against direct URL access to empty/inactive stock
        abort_unless(
            $listing->status === 'ACTIVE'
            && $listing->stock > 0,
            404
        );

        return view('customer.listing-detail', compact('listing'));
    }
}