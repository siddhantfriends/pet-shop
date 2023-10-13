<?php

namespace Database\Factories;

use App\Models\OrderStatus;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, string|object|int|float|null|array<string,string|array<string,string>>>
     */
    public function definition(): array
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();
        $delivery_fees = $this->calculateDeliveryFees($product->price);
        $total = $this->calculateTotals($product->price, $delivery_fees);

        return [
            'user_id' => $user->id,
            'order_status_id' => OrderStatus::factory()->create()->id,
            'payment_id' => Payment::factory()->creditCard()->create()->id,
            'products' =>  [
                ['product' => $product->uuid, 'quantity' => 2],
            ],
            'address' => [
                'billing' => $user->address,
                'shipping' => $user->address,
            ],
            'delivery_fees' => $delivery_fees,
            'amount' => $total,
        ];
    }

    public function freeDelivery(): static
    {
        return $this->state(fn (array $attributes) => [
            'price' => fake()->numberBetween(500, 1000),
        ]);
    }

    public function shipped(): static
    {
        return $this->state(fn (array $attributes) => [
            'shipped_at' => fake()->date,
        ]);
    }

    private function calculateDeliveryFees(float $price): float
    {
        return ($price < 500) ? 15: 0;
    }

    private function calculateTotals($price, $delivery_fees): float
    {
        return $price + $delivery_fees;
    }
}
