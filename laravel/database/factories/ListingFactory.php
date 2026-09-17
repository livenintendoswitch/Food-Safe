<?php

namespace Database\Factories;

use App\Models\Listing;
use App\Models\Restaurant;
use Illuminate\Database\Eloquent\Factories\Factory;

class ListingFactory extends Factory
{
    protected $model = Listing::class;

    public function definition(): array
    {
        return [
            'restaurant_id' => Restaurant::factory(),
            'name' => fake()->words(3, true),
            'description' => fake()->sentence(),
            'original_price' => 35000,
            'surplus_price' => 15000,
            'quantity' => 10,
            'pickup_start' => now()->addHour(),
            'pickup_end' => now()->addHours(2),
            'status' => 'ACTIVE',
        ];
    }
}
