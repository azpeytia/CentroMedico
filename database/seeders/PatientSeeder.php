<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Patient;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Patient::factory()->count(50)->create();

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
