<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'name' => 'Chair - Grid',
            'purchase_price' => 100.00,
            'sell_price' => 200.00,
            'stock' => 50,
            'opening_stock' => 50,
        ]);
        Product::create([
            'name' => 'Table - Grid',
            'purchase_price' => 100.00,
            'sell_price' => 200.00,
            'stock' => 50,
            'opening_stock' => 50,
        ]);
        Product::create([
            'name' => 'Battery',
            'purchase_price' => 100.00,
            'sell_price' => 200.00,
            'stock' => 50,
            'opening_stock' => 50,
        ]);
    }
}
