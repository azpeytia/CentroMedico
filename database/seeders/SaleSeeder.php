<?php

namespace Database\Seeders;

use App\Models\Sale;
use App\Models\SaleProduct;
use App\Models\Patient;
use App\Models\Shift;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $patient_id = Patient::first()->id;
        if (!$patient_id) {
            $patient = Patient::factory()->create();
            $patient_id = $patient->id;
        }

        $shift_id = Shift::first()->id;
        if (!$shift_id) {
            $shift = Shift::factory()->create();
            $shift_id = $shift->id;
        }

        $user_id = User::first()->id;
        if (!$user_id) {
            $user = User::factory()->create();
            $user_id = $user->id;
        }

        // Crea las ventas asociadas a un paciente, turno y producto
        // Sale::factory()->count(5)->create(['patient_id' => $patient_id, 'shift_id' => $shift_id, 'user_id' => $user_id])->each(function ($sale) {
            // Aquí se crean productos asociados a cada venta mediante el modelo SaleProduct
            // SaleProduct::factory()->count(3)->create(['sale_id' => $sale->id]);
        // });

        // Crea ventas con datos específicos
        Sale::create([
            'patient_id' => $patient_id,
            'shift_id' => $shift_id,
            'user_id' => $user_id,
            'total' => 100.00,
            'status' => 'Terminada',
            'payment_method' => 'Efectivo',
            'is_active' => true,
            'is_suspended' => false,
            'is_deleted' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}