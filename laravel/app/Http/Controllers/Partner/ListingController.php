<?php

namespace App\Http\Controllers\Partner;

use App\Models\Listing;
use App\Models\Restaurant;
use App\Http\Requests\Partner\ListingRequest;
use App\Services\Supply\ListingService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests; // 1. Import the trait
use Illuminate\Support\Facades\Auth; // 2. Import the Auth facade

class ListingController
{
    use AuthorizesRequests; // 3. This defines $this->authorize()

    public function __construct(private ListingService $listingService)
    {
    }

    public function index()
    {
        // 4. Use Auth::id() to clear the 'id' method error
        $restaurant = Restaurant::where('owner_id', Auth::id())->first();
        $listings = $restaurant ? $restaurant->listings()->latest()->get() : collect();

        return view('partner.listings.index', compact('listings', 'restaurant'));
    }

    public function create()
    {
        $restaurant = Restaurant::where('owner_id', Auth::id())->firstOrFail();
        return view('partner.listings.create', compact('restaurant'));
    }

    public function store(ListingRequest $request)
    {
        $restaurant = Restaurant::findOrFail($request->restaurant_id);

        if ($restaurant->owner_id !== Auth::id()) {
            abort(403, 'You do not own this restaurant.');
        }

        $this->listingService->createListing($request->validated());

        return redirect()->route('partner.listings.index')
                         ->with('success', 'Surplus listing created.');
    }

    public function edit(Listing $listing)
    {
        if ($listing->restaurant->owner_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('partner.listings.edit', compact('listing'));
    }

    public function update(ListingRequest $request, Listing $listing)
    {
        $this->authorize('update', $listing); // This now works via the trait

        $this->listingService->updateListing($listing, $request->validated());

        return redirect()->route('partner.listings.index')
                         ->with('success', 'Listing updated.');
    }

    public function destroy(Listing $listing)
    {
        $this->authorize('delete', $listing); // This now works via the trait

        $listing->delete();

        return redirect()->route('partner.listings.index')
                         ->with('success', 'Listing deleted.');
    }
}