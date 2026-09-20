<?php

namespace App\Http\Controllers\Customer;

use App\Models\Listing;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;

class ListingController
{
    public function home(): View
    {
        $listings = $this->availableListings()
            ->latest()
            ->take(6)
            ->get();

        return view('customer.discovery.home', compact('listings'));
    }

    public function index(): View
    {
        $listings = $this->availableListings()
            ->latest()
            ->get();

        return view('customer.discovery.listings', compact('listings'));
    }

    public function show(Listing $listing): View
    {
        $listing->load('restaurant');

        abort_unless($listing->isAvailable(), 404);

        return view('customer.discovery.listing-detail', compact('listing'));
    }

    private function availableListings(): Builder
    {
        return Listing::query()
            ->with('restaurant')
            ->where('status', 'ACTIVE')
            ->where('quantity', '>', 0)
            ->where('pickup_end', '>', now());
    }
}