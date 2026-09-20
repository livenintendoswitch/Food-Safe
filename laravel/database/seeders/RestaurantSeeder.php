<?php

namespace Database\Seeders;

use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class RestaurantSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $partners = User::where('role', 'partner')->get();

        // Real-world prominent locations in Jakarta
        $realJakartaLocations = [
            'Grand Indonesia, Jl. M.H. Thamrin No.1, Jakarta Pusat',
            'Pondok Indah Mall, Jl. Metro Pondok Indah, Jakarta Selatan',
            'Kota Kasablanka, Jl. Casablanca Raya Kav. 88, Jakarta Selatan',
            'Central Park Mall, Jl. Letjen S. Parman Kav. 28, Jakarta Barat',
            'Senayan City, Jl. Asia Afrika No. 19, Jakarta Pusat',
            'Kelapa Gading Mall, Jl. Boulevard Raya, Jakarta Utara',
            'Pacific Place, SCBD, Jl. Jend. Sudirman Kav. 52-53, Jakarta Selatan',
            'Lippo Mall Kemang, Jl. Pangeran Antasari No.36, Jakarta Selatan',
            'Plaza Indonesia, Jl. M.H. Thamrin No.28-30, Jakarta Pusat',
            'Gandaria City, Jl. Sultan Iskandar Muda, Jakarta Selatan'
        ];

        foreach ($partners as $partner) {
            if ($partner->email === 'partner@surplus.test') {
                // Original demo restaurant
                Restaurant::updateOrCreate(
                    ['owner_id' => $partner->id],
                    [
                        'name' => 'Green Bowl Restaurant',
                        'description' => 'Demo partner restaurant for surplus food orders.',
                        'address' => 'Sarinah, Jl. M.H. Thamrin No. 11, Jakarta Pusat',
                    ]
                );
            } else {
                // Extract brand name from "Brand Manager"
                $brandName = str_replace(' Manager', '', $partner->name);
                
                Restaurant::updateOrCreate(
                    ['owner_id' => $partner->id],
                    [
                        'name' => $brandName,
                        'description' => "Official {$brandName} surplus food distributor.",
                        // Assign a random real-world location from the array
                        'address' => $faker->randomElement($realJakartaLocations),
                    ]
                );
            }
        }
    }
}