<?php

namespace Database\Seeders;

use App\Models\Product as ModelsProduct;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Product extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            ModelsProduct::create([
                'name' => 'Product ' . $i,
                'purchase_price' => rand(80, 150),
                'sell_price' => rand(180, 300),
                'stock_quantity' => 100
            ]);
        }
    }
}
