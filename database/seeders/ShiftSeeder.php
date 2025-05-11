<?php

namespace Database\Seeders;

use App\Models\Shift;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShiftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Shift::factory()->count(5)->create();

        Shift::create([
            'name' => 'Matutino',
            'start_time' => '07:00:00',
            'end_time' => '14:59:59',
            'is_started' => false,
            'is_finished' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Shift::create([
            'name' => 'Vespertino',
            'start_time' => '15:00:00',
            'end_time' => '22:59:59',
            'is_started' => false,
            'is_finished' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Shift::create([
            'name' => 'Nocturno',
            'start_time' => '23:00:00',
            'end_time' => '23:59:59',
            'is_started' => false,
            'is_finished' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Shift::create([
            'name' => 'Nocturno',
            'start_time' => '00:00:01',
            'end_time' => '06:59:59',
            'is_started' => false,
            'is_finished' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}