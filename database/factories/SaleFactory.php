<?php

namespace Database\Factories;

use App\Models\Patient;
use App\Models\Shift;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sale>
 */
class SaleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'patient_id' => Patient::query()->inRandomOrder()->value('id') ?? Patient::factory(),
            'shift_id' => Shift::query()->inRandomOrder()->value('id') ?? Shift::factory(),
            'user_id' => User::query()->inRandomOrder()->value('id') ?? User::factory(),
            'total' => $this->faker->randomFloat(2, 0, 10000),
            'status' => $this->faker->randomElement(['Pendiente', 'Terminada']),
            'payment_method' => $this->faker->randomElement(['Efectivo', 'Debito', 'Credito']),
            'is_active' => true,
            'is_suspended' => false,
            'is_deleted' => false,
            'created_at' => $this->faker->dateTime(),
            'updated_at' => $this->faker->dateTime(),
        ];
    }
}