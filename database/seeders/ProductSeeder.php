<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Product::factory()->count(50)->create();

        Product::create([
            'category_id' => 1,
            'name' => 'Naproxeno Sodico 550 mg',
            'description' => 'Antiinflamatorio no esteroideo',
            'presentation' => 'Comprimidos',
            'stock' => 10,
            'max_stock' => 20,
            'min_stock' => 5,
            'price' => 100,
            'is_active' => true,
            'is_suspended' => false,
            'is_deleted' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Product::create([
            'category_id' => 1,
            'name' => 'Cefalexina 500 mg',
            'description' => 'Antibiótico',
            'presentation' => 'Cápsulas',
            'stock' => 10,
            'max_stock' => 20,
            'min_stock' => 5,
            'price' => 100,
            'is_active' => true,
            'is_suspended' => false,
            'is_deleted' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Product::create([
            'category_id' => 1,
            'name' => 'Fexofenadina 120 mg',
            'description' => 'Antihistamínico',
            'presentation' => 'Comprimidos',
            'stock' => 10,
            'max_stock' => 20,
            'min_stock' => 5,
            'price' => 100,
            'is_active' => true,
            'is_suspended' => false,
            'is_deleted' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Product::create([
            'category_id' => 1,
            'name' => 'Ciprofloxacino 500 mg',
            'description' => 'Antibiótico',
            'presentation' => 'Comprimidos',
            'stock' => 10,
            'max_stock' => 20,
            'min_stock' => 5,
            'price' => 100,
            'is_active' => true,
            'is_suspended' => false,
            'is_deleted' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Product::create([
            'category_id' => 1,
            'name' => 'Cloruro de sodio 0.9% 1000 ml',
            'description' => 'Solución salina',
            'presentation' => 'Solución intravenosa',
            'stock' => 10,
            'max_stock' => 20,
            'min_stock' => 5,
            'price' => 100,
            'is_active' => true,
            'is_suspended' => false,
            'is_deleted' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}