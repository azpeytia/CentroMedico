<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        /* User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]); */

        User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'email_verified_at' => now(),
            'password' => bcrypt('adminCR2025'),
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->call(CategorySeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(ShiftSeeder::class);
        $this->call(InventorySeeder::class);
        $this->call(PatientSeeder::class);
        $this->call(SaleSeeder::class);
        $this->call(SaleProductSeeder::class);
    }
}