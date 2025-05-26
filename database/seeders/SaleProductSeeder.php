<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleProduct;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SaleProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $product_id = Product::first()->id;
        if (!$product_id) {
            $product = Product::factory()->create();
            $product_id = $product->id;
        }
        $sale_id = Sale::first()->id;
        if (!$sale_id) {
            $sale = Sale::factory()->create();
            $sale_id = $sale->id;
        }

        // Crea productos de venta con datos específicos
        SaleProduct::create([
            'sale_id' => $sale_id,
            'product_id' => $product_id,
            'quantity' => 2,
            'unit_price' => 50.00,
            'subtotal' => 100.00,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}