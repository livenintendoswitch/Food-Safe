<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'customer@surplus.test'],
            ['name' => 'Demo Customer', 'password' => 'password', 'role' => 'customer']
        );

        User::updateOrCreate(
            ['email' => 'partner@surplus.test'],
            ['name' => 'Demo Partner', 'password' => 'password', 'role' => 'partner']
        );

        User::updateOrCreate(
            ['email' => 'admin@surplus.test'],
            ['name' => 'Demo Admin', 'password' => 'password', 'role' => 'admin']
        );
    }
}
