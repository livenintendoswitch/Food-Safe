<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            // 1. Users must be created first so owner_id exists
            UserSeeder::class,
            
            // 2. Restaurants require a valid partner User
            RestaurantSeeder::class,
            
            // 3. Listings require a valid Restaurant
            ListingSeeder::class,
        ]);
    }
}