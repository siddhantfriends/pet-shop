<?php

namespace Tests\Feature;

use App\Models\OrderStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class OrderStatusTest extends BaseTestCase
{
    use RefreshDatabase;

    public const TABLE = 'order_statuses';

    /**
     * Checks if user can create order status
     *
     * @test
     */
    public function user_can_create_order_status(): void
    {
        $orderStatus = OrderStatus::factory()->make();
        $response = $this->post(
            route('order-status.store'),
            ['title' => $orderStatus->title],
            $this->getAuthorizationHeader($this->user)
        );

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonMissingValidationErrors()
            ->assertJsonPath('success', 1);

        $this->assertDatabaseHas(self::TABLE, [
            'title' => $orderStatus->title,
        ]);
    }

    /**
     * Checks if user can update a order status
     *
     * @test
     */
    public function user_can_update_a_order_status(): void
    {
        $orderStatus = OrderStatus::factory()->create();
        $edit = OrderStatus::factory()->make();

        $this->assertDatabaseHas(self::TABLE, [
            'title' => $orderStatus->title,
        ]);

        $response = $this->put(
            route('order-status.update', ['order_status' => $orderStatus->uuid]),
            ['title' => $edit->title],
            $this->getAuthorizationHeader($this->user)
        );

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonMissingValidationErrors()
            ->assertJsonPath('success', 1);

        $this->assertDatabaseHas(self::TABLE, [
            'title' => $edit->title,
        ]);
    }

    /**
     * Checks if user can update a order status
     *
     * @test
     */
    public function user_cannot_update_a_non_existing_order_status(): void
    {
        $orderStatus = OrderStatus::factory()->make();

        $this->assertDatabaseMissing(self::TABLE, [
            'title' => $orderStatus->title,
        ]);

        $response = $this->put(
            route('order-status.update', ['order_status' => 'uuid-not-exists']),
            ['title' => $orderStatus->title],
            $this->getAuthorizationHeader($this->user)
        );

        $response->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJsonMissingValidationErrors()
            ->assertJsonPath('success', 0);
    }

    /**
     * Can show order status without any authorization
     *
     * @test
     */
    public function can_show_order_status_without_authorization(): void
    {
        $orderStatus = OrderStatus::factory()->create();

        $response = $this->get(route('order-status.show', ['order_status' => $orderStatus->uuid]));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonMissingValidationErrors()
            ->assertJsonPath('success', 1);
    }

    /**
     * Can list all  without authorization.
     * The list is paginated therefore displaying current page.
     *
     * @test
     */
    public function can_list_all__without_authorization(): void
    {
        OrderStatus::factory(20)->create();

        $response = $this->get(route('order-statuses.index'));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonMissingValidationErrors()
            ->assertJsonPath('current_page', 1);
    }

    /**
     * Ensures that the order status can be deleted
     *
     * @test
     */
    public function can_delete_a_order_status(): void
    {
        $orderStatus = OrderStatus::factory()->create();

        $response = $this->delete(
            route('order-status.destroy', ['order_status' => $orderStatus->uuid]),
            headers: $this->getAuthorizationHeader($this->user)
        );

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonMissingValidationErrors()
            ->assertJsonPath('success', 1);
    }

    /**
     * Ensures that the order status cannot be deleted without authorization
     *
     * @test
     */
    public function cannot_delete_a_order_status_without_authorization(): void
    {
        $orderStatus = OrderStatus::factory()->create();

        $response = $this->delete(route('order-status.destroy', [
            'order_status' => $orderStatus->uuid,
        ]));

        $response->assertStatus(Response::HTTP_UNAUTHORIZED)
            ->assertJsonMissingValidationErrors();
    }
}
