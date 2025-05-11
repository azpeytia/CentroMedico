<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Inventory;

class InventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Inventory::factory()->count(50)->create();

        Inventory::create([
            'product_id' => 1,
            'shift_id' => 1,
            'date' => now(),
            'opening_stock' => 100,
            'sold_stock' => 50,
            'closing_stock' => 50,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}