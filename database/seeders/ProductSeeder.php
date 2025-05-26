<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category_id = Category::first()->id;
        if (!$category_id) {
            $category = Category::factory()->create();
            $category_id = $category->id;
        }

        // Crea los productos asociados a la primera categoría
        // Product::factory()->count(5)->create(['category_id' => $category_id]);

        // Crea productos con datos específicos
        Product::create([
            'category_id' => $category_id,
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
            'category_id' => $category_id,
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
            'category_id' => $category_id,
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
            'category_id' => $category_id,
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
            'category_id' => $category_id,
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