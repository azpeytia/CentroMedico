<?php

namespace Database\Seeders;

use App\Models\Doctor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crea 5 doctores utilizando el factory
        // Doctor::factory()->count(5)->create();

        // Crea doctores con datos específicos
        Doctor::create([
            'name' => 'Dr. Juan Perez',
            'license_number' => 'LIC123456',
            'specialty' => 'Cardiología',
            'phone' => '555-1234-5678',
            'email' => 'juan.perez@example.com',
            'is_active' => true,
            'is_suspended' => false,
            'is_deleted' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
