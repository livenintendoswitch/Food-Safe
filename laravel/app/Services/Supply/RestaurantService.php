<?php

namespace App\Services\Supply;

use App\Models\Restaurant;
use App\Models\User;

class RestaurantService
{
    public function createRestaurant(User $partner, array $validatedData): Restaurant
    {
        // Enforce ownership at the service layer
        $validatedData['owner_id'] = $partner->id;
        
        return Restaurant::create($validatedData);
    }

    public function updateRestaurant(Restaurant $restaurant, array $validatedData): bool
    {
        return $restaurant->update($validatedData);
    }
}