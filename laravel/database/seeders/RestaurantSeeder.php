<?php

namespace Database\Seeders;

use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Database\Seeder;

class RestaurantSeeder extends Seeder
{
    public function run(): void
    {
        $partner = User::where('email', 'partner@surplus.test')->firstOrFail();

        Restaurant::updateOrCreate(
            ['owner_id' => $partner->id],
            [
                'name' => 'Green Bowl Restaurant',
                'description' => 'Demo partner restaurant for surplus food orders.',
                'address' => 'Jakarta',
            ]
        );
    }
}
