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
        // Se elimina lo siguiente para evitar problemas al correr el seeder en producción, se puede quitar si se desea generar
        // registros en desarrollo.

        /* $product_id = Product::first()->id;
        if (!$product_id) {
            $product = Product::factory()->create();
            $product_id = $product->id;
        }
        $sale_id = Sale::first()->id;
        if (!$sale_id) {
            $sale = Sale::factory()->create();
            $sale_id = $sale->id;
        } */

        // Genera una venta base para el producto
        $sale = Sale::first();
        if (!$sale) {
            $sale = Sale::create([
                'patient_id' => 1,
                'shift_id' => 1,
                'user_id' => 1,
                'total' => 100.00,
                'status' => 'Terminada',
                'payment_method' => 'Efectivo',
                'is_active' => true,
                'is_suspended' => false,
                'is_deleted' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        $sale_id = $sale->id;

        // Genera un producto base para la venta
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
                'price' => 50.00,
                'is_active' => true,
                'is_suspended' => false,
                'is_deleted' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        $product_id = $product->id;
        
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