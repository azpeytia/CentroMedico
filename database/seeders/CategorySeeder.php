<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crea 5 categorías utilizando el factory
        // Category::factory()->count(5)->create();

        // Crea categorías con datos específicos
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