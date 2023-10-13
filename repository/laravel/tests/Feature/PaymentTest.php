<?php

namespace Tests\Feature;

use App\Models\Payment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class PaymentTest extends BaseTestCase
{
    use RefreshDatabase;

    public const TABLE = 'payments';

    /**
     * Checks if user can create payment
     *
     * @test
     */
    public function user_can_create_payment(): void
    {
        $payment = Payment::factory()->credit_card()->make();
        $response = $this->post(
            route('payment.store'),
            [
                'type' => $payment->type,
                'details' => json_encode($payment->details),
            ],
            $this->getAuthorizationHeader($this->user)
        );

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonMissingValidationErrors()
            ->assertJsonPath('success', 1);

        $this->assertDatabaseHas(self::TABLE, [
            'type' => $payment->type,
        ]);
    }

    /**
     * Checks if user can update a payment
     *
     * @test
     */
    public function user_can_update_a_payment(): void
    {
        $payment = Payment::factory()->credit_card()->create();
        $edit = Payment::factory()->credit_card()->make();

        $this->assertDatabaseHas(self::TABLE, [
            'type' => $payment->type,
        ]);

        $response = $this->put(
            route('payment.update', ['payment' => $payment->uuid]),
            [
                'type' => $edit->type,
                'details' => json_encode($edit->details),
            ],
            $this->getAuthorizationHeader($this->user)
        );

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonMissingValidationErrors()
            ->assertJsonPath('success', 1);

        $this->assertDatabaseHas(self::TABLE, [
            'type' => $edit->type,
        ]);
    }

    /**
     * Checks if user can update a payment
     *
     * @test
     */
    public function user_cannot_update_a_non_existing_payment(): void
    {
        $payment = Payment::factory()->credit_card()->make();

        $this->assertDatabaseMissing(self::TABLE, [
            'type' => $payment->type,
        ]);

        $response = $this->put(
            route('payment.update', ['payment' => 'uuid-not-exists']),
            [
                'type' => $payment->type,
                'details' => $payment->details,
            ],
            $this->getAuthorizationHeader($this->user)
        );

        $response->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJsonMissingValidationErrors()
            ->assertJsonPath('success', 0);
    }

    /**
     * Can show payment without any authorization
     *
     * @test
     */
    public function can_show_payment_without_authorization(): void
    {
        $payment = Payment::factory()->credit_card()->create();

        $response = $this->get(
            route('payment.show', ['payment' => $payment->uuid]),
            headers: $this->getAuthorizationHeader($this->user)
        );

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonMissingValidationErrors()
            ->assertJsonPath('success', 1);
    }

    /**
     * Cannot list all payments without authorization.
     *
     * @test
     */
    public function cannot_list_all_payments_without_authorization(): void
    {
        Payment::factory(20)->credit_card()->create();

        $response = $this->get(route('payments.index'));

        $response->assertStatus(Response::HTTP_UNAUTHORIZED)
            ->assertJsonMissingValidationErrors();
    }

    /**
     * Ensures that the payment can be deleted
     *
     * @test
     */
    public function can_delete_a_payment(): void
    {
        $payment = Payment::factory()->credit_card()->create();

        $response = $this->delete(
            route('payment.destroy', ['payment' => $payment->uuid]),
            headers: $this->getAuthorizationHeader($this->user)
        );

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonMissingValidationErrors()
            ->assertJsonPath('success', 1);
    }

    /**
     * Ensures that the payment cannot be deleted without authorization
     *
     * @test
     */
    public function cannot_delete_a_payment_without_authorization(): void
    {
        $payment = Payment::factory()->credit_card()->create();

        $response = $this->delete(route('payment.destroy', [
            'payment' => $payment->uuid,
        ]));

        $response->assertStatus(Response::HTTP_UNAUTHORIZED)
            ->assertJsonMissingValidationErrors();
    }
}
