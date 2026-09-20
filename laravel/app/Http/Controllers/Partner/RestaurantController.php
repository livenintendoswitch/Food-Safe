<?php

namespace App\Http\Controllers\Partner;

use App\Models\Restaurant;
use App\Http\Requests\Partner\RestaurantRequest;
use App\Services\Supply\RestaurantService;
use Illuminate\Support\Facades\Auth;

class RestaurantController
{
    public function __construct(private RestaurantService $restaurantService)
    {
    }

    public function index()
    {
        $restaurant = Restaurant::where('owner_id', Auth::id())->first();
        return view('partner.restaurants.index', compact('restaurant'));
    }

    public function create()
    {
        return view('partner.restaurants.create');
    }

    public function store(RestaurantRequest $request)
    {
        // $request->user() is safe here because it is passed directly into the Service
        $this->restaurantService->createRestaurant(
            $request->user(), 
            $request->validated()
        );

        return redirect()->route('partner.restaurants.index')
                         ->with('success', 'Restaurant profile created.');
    }

    public function edit(Restaurant $restaurant)
    {
        if ($restaurant->owner_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('partner.restaurants.edit', compact('restaurant'));
    }

    public function update(RestaurantRequest $request, Restaurant $restaurant)
    {
        if ($restaurant->owner_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $this->restaurantService->updateRestaurant($restaurant, $request->validated());

        return redirect()->route('partner.restaurants.index')
                         ->with('success', 'Restaurant updated successfully.');
    }
}