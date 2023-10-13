<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\File;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, string|object|null>
     */
    public function definition(): array
    {
        return [
            'category_uuid' => Category::factory()->create()->uuid,
            'title' => fake()->text(120),
            'price' => fake()->numberBetween(100, 900),
            'description' => fake()->paragraph,
            'metadata' => json_encode([
                'brand' => fake()->title,
                'image' => File::factory()->create(),
            ]),
        ];
    }
}
