<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\Product;

class OrderProductTableSeeder extends Seeder
{
    public function run()
    {
        // Obtenez tous les IDs de commande et de produit existants
        $orderIds = Order::pluck('id')->toArray();
        $productIds = Product::pluck('id')->toArray();

        // Assurez-vous qu'il existe des commandes et des produits
        if (empty($orderIds) || empty($productIds)) {
            // Vous pourriez vouloir appeler ici les seeders de Product et Order si nécessaire
            echo "Please seed orders and products first.\n";
            return;
        }

        // Créez un ensemble de données de relation commande-produit
      // ...
foreach (range(1, 10) as $index) {
    // Génère des paires uniques order_id et product_id
    $orderId = $orderIds[array_rand($orderIds)];
    $productId = $productIds[array_rand($productIds)];

    // Vérifiez si la paire existe déjà
    $exists = DB::table('order_product')->where('order_id', $orderId)->where('product_id', $productId)->exists();

    if (!$exists) {
        DB::table('order_product')->insert([
            'order_id' => $orderId,
            'product_id' => $productId,
            'quantity' => random_int(1, 10),
            'price' => random_int(100, 1000) / 100,
        ]);
    } else {
        // La paire existe déjà, vous pourriez choisir de générer un nouveau couple ou de passer à la suite
    }
}

    }
}
