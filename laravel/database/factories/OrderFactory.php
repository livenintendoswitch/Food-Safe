<?php

namespace Database\Factories;

use App\Models\Listing;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        $listing = Listing::factory()->create();
        $quantity = 1;

        return [
            'customer_id' => User::factory(),
            'restaurant_id' => $listing->restaurant_id,
            'listing_id' => $listing->id,
            'quantity' => $quantity,
            'total_price' => $listing->surplus_price * $quantity,
            'payment_status' => 'PAID',
            'order_status' => 'PAID',
            'pickup_code' => fake()->unique()->numerify('######'),
        ];
    }
}
