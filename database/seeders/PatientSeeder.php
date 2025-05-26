<?php

namespace Database\Seeders;

use App\Models\Patient;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crea 5 pacientes utilizando el factory
        // Patient::factory()->count(5)->create();

        // Crea pacientes con datos específicos
        Patient::create([
            'name' => 'Juan Perez',
            'address' => 'Calle Falsa 123',
            'city' => 'Ciudad de Mexico',
            'state' => 'CDMX',
            'zip_code' => '01234',
            'phone' => '555-1234-5678',
            'sex' => 'Masculino',
            'birthdate' => '1990-01-01',
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}