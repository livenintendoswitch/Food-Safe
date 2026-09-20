<?php

namespace App\Http\Controllers\Customer;

use App\Models\Listing;
use Illuminate\View\View;

class ListingController
{
    public function home(): View
    {
        $listings = Listing::query()
            ->with('restaurant')
            ->where('status', 'ACTIVE')
            ->where('quantity', '>', 0)
            ->latest()
            ->take(6)
            ->get();

        return view('customer.discovery.home', compact('listings'));
    }

    public function index(): View
    {
        $listings = Listing::query()
            ->with('restaurant')
            ->where('status', 'ACTIVE')
            ->where('quantity', '>', 0)
            ->latest()
            ->get();

        return view('customer.discovery.listings', compact('listings'));
    }

    public function show(Listing $listing): View
    {
        $listing->load('restaurant');

        abort_unless(
            $listing->status === 'ACTIVE'
            && $listing->quantity > 0,
            404
        );

        return view('customer.discovery.listing-detail', compact('listing'));
    }
}
