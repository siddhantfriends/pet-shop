<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, string|object|null>
     */
    public function definition(): array
    {
        return [];
    }

    public function credit_card(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'credit_card',
            'details' => [
                'holder_name' => fake()->firstName,
                'number' => fake()->creditCardNumber,
                'ccv' => fake()->randomNumber(3, true),
                'expiry_date' => fake()->creditCardExpirationDateString,
            ]
        ]);
    }

    public function cash_on_delivery(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'cash_on_delivery',
            'details' => [
                'first_name' => fake()->firstName,
                'last_name' => fake()->lastName,
                'address' => fake()->address,
            ],
        ]);
    }

    public function bank_transfer(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'bank_transfer',
            'details' => [
                'swift' => fake()->swiftBicNumber,
                'iban' => fake()->iban,
                'name' => fake()->name,
            ],
        ]);
    }
}
