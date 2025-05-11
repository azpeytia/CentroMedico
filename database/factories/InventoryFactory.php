<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Shift;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Inventory>
 */
class InventoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::query()->inRandomOrder()->value('id') ?? Product::factory(),
            'shift_id' => Shift::query()->inRandomOrder()->value('id') ?? Shift::factory(),
            'date' => $this->faker->dateTime(),
            'opening_stock' => $this->faker->numberBetween(0, 1000),
            'sold_stock' => $this->faker->numberBetween(0, 1000),
            'closing_stock' => $this->faker->numberBetween(0, 1000),
            'created_at' => $this->faker->dateTime(),
            'updated_at' => $this->faker->dateTime(),
        ];
    }
}
