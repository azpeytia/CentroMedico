<?php

namespace Database\Seeders;

use App\Models\Inventory;
use App\Models\Product;
use App\Models\Shift;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InventorySeeder extends Seeder
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
        $shift_id = Shift::first()->id;
        if (!$shift_id) {
            $shift = Shift::factory()->create();
            $shift_id = $shift->id;
        }

        // Crea los inventarios asociados al primer producto y turno
        // Inventory::factory()->count(5)->create(['product_id' => $product_id, 'shift_id' => $shift_id]);

        // Crea un inventario con datos específicos
        Inventory::create([
            'product_id' => $product_id,
            'shift_id' => $shift_id,
            'date' => now(),
            'opening_stock' => 100,
            'sold_stock' => 50,
            'closing_stock' => 50,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}