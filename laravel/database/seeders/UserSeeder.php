<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $password = Hash::make('password');
        $faker = Faker::create();

        // 1. Core Demo Accounts
        User::updateOrCreate(
            ['email' => 'customer@surplus.test'],
            ['name' => 'Demo Customer', 'password' => $password, 'role' => 'customer']
        );

        User::updateOrCreate(
            ['email' => 'partner@surplus.test'],
            ['name' => 'Demo Partner', 'password' => $password, 'role' => 'partner']
        );

        User::updateOrCreate(
            ['email' => 'admin@surplus.test'],
            ['name' => 'Demo Admin', 'password' => $password, 'role' => 'admin']
        );

        // 2. Real Brand Partner Accounts
        $brands = [
            'McDonalds', 'Burger King', 'KFC', 'Subway', 'Starbucks', 
            'Wendys', 'Taco Bell', 'Dominos', 'Pizza Hut', 'Chipotle'
        ];

        foreach ($brands as $brand) {
            User::updateOrCreate(
                ['email' => strtolower(str_replace(' ', '', $brand)) . '@partner.test'],
                ['name' => $brand . ' Manager', 'password' => $password, 'role' => 'partner']
            );
        }

        // 3. Realistic Mock Customers
        for ($i = 0; $i < 20; $i++) {
            User::updateOrCreate(
                ['email' => $faker->unique()->safeEmail()],
                ['name' => $faker->name(), 'password' => $password, 'role' => 'customer']
            );
        }
    }
}