<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_id' => Category::query()->inRandomOrder()->value('id') ?? Category::factory(),
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'presentation' => $this->faker->word(),
            'stock' => $this->faker->numberBetween(0, 100),
            'max_stock' => $this->faker->numberBetween(100, 200),
            'min_stock' => $this->faker->numberBetween(0, 50),
            'price' => $this->faker->randomFloat(2, 1, 100),
            'is_active' => true,
            'is_suspended' => false,
            'is_deleted' => false,
            'created_at' => $this->faker->dateTime(),
            'updated_at' => $this->faker->dateTime(),
        ];
    }
}