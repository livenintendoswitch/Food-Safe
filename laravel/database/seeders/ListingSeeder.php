<?php

namespace Database\Seeders;

use App\Models\Listing;
use App\Models\Restaurant;
use Illuminate\Database\Seeder;

class ListingSeeder extends Seeder
{
    public function run(): void
    {
        $restaurant = Restaurant::firstOrFail();

        Listing::updateOrCreate(
            ['restaurant_id' => $restaurant->id, 'name' => 'Chicken Rice Bowl'],
            [
                'description' => 'Surplus chicken rice bowl for same-day pickup.',
                'original_price' => 35000,
                'surplus_price' => 15000,
                'quantity' => 10,
                'pickup_start' => now()->addHour(),
                'pickup_end' => now()->addHours(2),
                'status' => 'ACTIVE',
            ]
        );

        Listing::updateOrCreate(
            ['restaurant_id' => $restaurant->id, 'name' => 'Mixed Pasta Box'],
            [
                'description' => 'Surplus mixed pasta box for same-day pickup.',
                'original_price' => 30000,
                'surplus_price' => 12000,
                'quantity' => 8,
                'pickup_start' => now()->addHour(),
                'pickup_end' => now()->addHours(2),
                'status' => 'ACTIVE',
            ]
        );
    }
}
