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
        // Se elimina lo siguiente para evitar problemas al correr el seeder en producción, se puede quitar si se desea generar
        // registros en desarrollo.

        /* $product_id = Product::first()->id;
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
        Inventory::factory()->count(5)->create(['product_id' => $product_id, 'shift_id' => $shift_id]);*/

        // Genera un turno base para el inventario
        $shift = Shift::first();
        if (!$shift) {
            $shift = Shift::create([
                'user_id' => 1,
                'name' => 'Turno Matutino',
                'start_time' => '07:00:00',
                'end_time' => '15:00:00',
                'is_started' => false,
                'is_finished' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        $shift_id = $shift->id;

        // Genera un producto base para el inventario
        $product = Product::first();
        if (!$product) {
            $product = Product::create([
                'category_id' => 1,
                'gtin_code' => '8470007210337',
                'name' => 'Naproxeno Sodico 550 mg',
                'description' => 'Antinflamatorio no esteroideo',
                'presentation' => 'Comprimidos',
                'stock' => 10,
                'max_stock' => 20,
                'min_stock' => 5,
                'price' => 150.00,
                'is_active' => true,
                'is_suspended' => false,
                'is_deleted' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        $product_id = $product->id;

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