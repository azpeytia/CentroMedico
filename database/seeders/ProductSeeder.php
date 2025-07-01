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
        // Se elimina lo siguiente para evitar problemas al correr el seeder en producción, se puede quitar si se desea generar
        // registros en desarrollo.

        /* $category_id = Category::first()->id;
        if (!$category_id) {
            $category = Category::factory()->create();
            $category_id = $category->id;
        }

        // Crea los productos asociados a la primera categoría
        Product::factory()->count(5)->create(['category_id' => $category_id]); */

        // Genera una categoría base para los productos
        $category = Category::first();
        if (!$category) {
            $category = Category::create([
                'name' => 'Medicamentos',
                'description' => 'Medicamentos de uso general',
                'is_active' => true,
                'is_suspended' => false,
                'is_deleted' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        $category_id = $category->id;

        // Crea productos con datos específicos
        Product::create([
            'category_id' => $category_id,
            'gtin_code' => '8470007210337',
            'name' => 'Naproxeno Sodico 550 mg',
            'description' => 'Antinflamatorio no esteroideo',
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
            'gtin_code' => '7502009745607',
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
            'gtin_code' => '8470007061335',
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
            'gtin_code' => '7501125196386',
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
            'gtin_code' => '7501125115479',
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