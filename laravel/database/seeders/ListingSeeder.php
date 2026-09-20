<?php

namespace Database\Seeders;

use App\Models\Listing;
use App\Models\Restaurant;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ListingSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $restaurants = Restaurant::all();
        
        // Real-world menus mapped to the generated brands
        $menus = [
            'McDonalds' => ['Big Mac Extra Value Meal', '10-piece Chicken McNuggets', 'Cheeseburger Combo', 'McSpicy Meal'],
            'Burger King' => ['Whopper Meal', 'Chicken Royale Meal', 'Mushroom Swiss Burger', 'BBQ Beef Rasher'],
            'KFC' => ['Super Family Bucket', 'Zinger Burger Box', '2-Piece Chicken Combo', 'O.R. Burger Meal'],
            'Subway' => ['Italian B.M.T. Footlong', 'Roasted Chicken Sub', 'Tuna Sandwich 6-inch', 'Meatball Marinara'],
            'Starbucks' => ['Caramel Macchiato & Pastry', 'Assorted Muffin Box', 'Sandwich & Americano Set', 'Croissant Trio'],
            'Wendys' => ['Daves Single Combo', 'Spicy Chicken Sandwich', 'Beef Chili Soup & Fries', 'Baconator Meal'],
            'Taco Bell' => ['Crunchwrap Supreme', '3 Soft Tacos Combo', 'Nachos BellGrande', 'Burrito Cravings Pack'],
            'Dominos' => ['Pepperoni Large Pizza', 'MeatZZa Medium Pizza', 'Garlic Bread & Wings', 'American Classic Cheeseburger Pizza'],
            'Pizza Hut' => ['Super Supreme Pan Pizza', 'Meat Lovers Stuffed Crust', 'Personal Pan Combo', 'Spaghetti Meat Sauce'],
            'Chipotle' => ['Chicken Burrito Bowl', 'Steak Tacos Pack', 'Veggie Bowl with Guac', 'Massive Burrito Pack']
        ];

        // Fallback menu for the Demo 'Green Bowl' restaurant
        $defaultMenu = ['Chicken Rice Bowl', 'Mixed Pasta Box', 'Grilled Chicken Salad', 'Beef Black Pepper Bento'];

        foreach ($restaurants as $restaurant) {
            // Get the specific menu for this brand, or use the default if not found
            $brandMenu = $menus[$restaurant->name] ?? $defaultMenu;
            
            // Shuffle the menu so listings are slightly randomized
            shuffle($brandMenu);
            
            // Pick 2 to 3 distinct items for this specific restaurant
            $listingCount = rand(2, 3);
            $selectedItems = array_slice($brandMenu, 0, $listingCount);
            
            foreach ($selectedItems as $itemName) {
                // Generate realistic Indonesian Rupiah pricing (e.g., 40.000 to 120.000)
                $originalPrice = $faker->numberBetween(40, 120) * 1000;
                $surplusPrice = round($originalPrice * 0.4); // 60% discount

                Listing::updateOrCreate(
                    [
                        'restaurant_id' => $restaurant->id, 
                        'name' => $itemName
                    ],
                    [
                        'description' => "End-of-day surplus of perfectly good {$itemName}. Prepared fresh today by {$restaurant->name} and packed for secure pickup.",
                        'original_price' => $originalPrice,
                        'surplus_price' => $surplusPrice,
                        'quantity' => $faker->numberBetween(2, 8),
                        'pickup_start' => now()->addHours(rand(1, 2)),
                        'pickup_end' => now()->addHours(rand(3, 5)),
                        'status' => 'ACTIVE',
                    ]
                );
            }
        }
    }
}