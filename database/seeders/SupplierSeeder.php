<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Supplier;
use Faker\Factory as Faker;

class SupplierSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 10) as $index) {
            Supplier::create([
                'name' => $faker->company,
                'contact_name' => $faker->name,
                'email' => $faker->email,
                'phone' => $faker->phoneNumber,
                'address' => $faker->address,
            ]);
        }
    }
}
