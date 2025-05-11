<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Category::factory()->count(5)->create();

        Category::create([
            'name' => 'Medicamentos',
            'description' => 'Medicamentos de uso general',
            'is_active' => true,
            'is_suspended' => false,
            'is_deleted' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Category::create([
            'name' => 'Suplementos',
            'description' => 'Suplementos alimenticios',
            'is_active' => true,
            'is_suspended' => false,
            'is_deleted' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Category::create([
            'name' => 'Equipos médicos',
            'description' => 'Equipos médicos de uso general',
            'is_active' => true,
            'is_suspended' => false,
            'is_deleted' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Category::create([
            'name' => 'Material de curación',
            'description' => 'Material de curación y vendaje',
            'is_active' => true,
            'is_suspended' => false,
            'is_deleted' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Category::create([
            'name' => 'Higiene personal',
            'description' => 'Productos de higiene personal',
            'is_active' => true,
            'is_suspended' => false,
            'is_deleted' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}