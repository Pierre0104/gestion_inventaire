<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Customer;
use Carbon\Carbon;

class OrderTableSeeder extends Seeder
{
    public function run()
    {
        // Assurez-vous que vous avez déjà des données dans la table customers.
        $customerIds = Customer::pluck('id')->toArray();

        // Vérifiez s'il y a des clients à associer.
        if (empty($customerIds)) {
            echo "No customers found. Please seed customers first.\n";
            return;
        }

        // Utilisez Faker pour générer des données fictives.
        $faker = \Faker\Factory::create();

        // Insérez les données fictives dans la table orders.
        foreach (range(1, 10) as $index) {
            DB::table('orders')->insert([
                'customer_id' => $faker->randomElement($customerIds),
                'order_date' => $faker->date(),
                'total_price' => $faker->randomFloat(2, 50, 5000), // 2 décimales, min 50, max 5000
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
