<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Supplier;

// ...
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 10) as $index) {
            Product::create([
                'name' => $faker->word,
                'description' => $faker->text(200),
                'price' => $faker->randomFloat(2, 10, 100),
                'stock' => $faker->numberBetween(1, 100),
                'supplier_id' => Supplier::inRandomOrder()->first()->id
            ]);
        }
    }
}
