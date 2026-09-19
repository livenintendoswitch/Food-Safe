<?php

namespace App\Http\Controllers\Customer;

use App\Models\Listing;
use Illuminate\Http\Request;

class ListingController
{
    public function index(Request $request)
    {
        // Customers are just browsing, so we only fetch active listings 
        // that still have stock, eager-loading the restaurant.
        $listings = Listing::with('restaurant')
            ->where('stock', '>', 0)
            ->latest()
            ->get();

        return view('customer.browse', compact('listings'));
    }

    public function show(Listing $listing)
    {
        // Load the associated restaurant so Frontend 1 can display the restaurant name and location
        $listing->load('restaurant');

        return view('customer.listing-detail', compact('listing'));
    }
}