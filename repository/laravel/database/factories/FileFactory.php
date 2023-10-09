<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class FileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    #[ArrayShape(['name' => "string", 'path' => "mixed", 'size' => "string", 'type' => "string"])]
    public function definition(): array
    {
        return [
            'name' => fake()->name,
            'path' => fake()->filePath(),
            'size' => '2M',
            'type' => 'jpg',
        ];
    }

    #[ArrayShape(['type' => "string"])]
    public function png(): array {
        return [
            'type' => 'png',
        ];
    }
}
