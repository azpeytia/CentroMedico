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
        // Se elimina lo siguiente para evitar problemas al correr el seeder en producción, se puede quitar si se desea generar
        // registros en desarrollo.

        /* $patient_id = Patient::first()->id;
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
        Sale::factory()->count(5)->create(['patient_id' => $patient_id, 'shift_id' => $shift_id, 'user_id' => $user_id])->each(function ($sale) {
            // Aquí se crean productos asociados a cada venta mediante el modelo SaleProduct
            SaleProduct::factory()->count(3)->create(['sale_id' => $sale->id]);
        }); */


        // Genera un paciente base para la venta
        $patient = Patient::first();
        if (!$patient) {
            $patient = Patient::create([
                'name' => 'Juan Perez',
                'email' => 'test@example.com',
                'phone' => '1234567890',
                'address' => '123 Test St',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        $patient_id = $patient->id;

        // Genera un turno base para la venta
        $shift = Shift::first();
        if (!$shift) {
            $shift = Shift::create([
                'user_id' => 1,
                'name' => 'Turno Matutino',
                'start_time' => '07:00:00',
                'end_time' => '15:00:00',
                'is_started' => false,
                'is_finished' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        $shift_id = $shift->id;

        // Genera un usuario base para la venta
        $user = User::first();
        if (!$user) {
            $user = User::create([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'email_verified_at' => now(),
                'password' => bcrypt('password'),
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        $user_id = $user->id;

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