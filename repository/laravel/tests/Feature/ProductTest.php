<?php

namespace Tests\Feature;

use App\Models\Product;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class ProductTest extends BaseTestCase
{
    use RefreshDatabase;

    public const TABLE = 'products';

    /**
     * Checks if user can create product
     *
     * @test
     */
    public function user_can_create_product(): void
    {
        $product = Product::factory()->make();
        $response = $this->post(
            route('product.store'),
            [
                'category_uuid' => $product->category_uuid,
                'title' => $product->title,
                'price' => $product->price,
                'description' => $product->description,
                'metadata' => $product->metadata,
            ],
            $this->getAuthorizationHeader($this->user)
        );

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonMissingValidationErrors()
            ->assertJsonPath('success', 1);

        $this->assertDatabaseHas(self::TABLE, [
            'title' => $product->title,
        ]);
    }

    /**
     * Checks if user can update a product
     *
     * @test
     */
    public function user_can_update_a_product(): void
    {
        $product = Product::factory()->create();
        $edit = Product::factory()->make();

        $this->assertDatabaseHas(self::TABLE, [
            'category_uuid' => $product->category_uuid,
            'title' => $product->title,
            'price' => $product->price,
            'description' => $product->description,
            'metadata' => $product->metadata,
        ]);

        $response = $this->put(
            route('product.update', ['product' => $product->uuid]),
            [
                'category_uuid' => $edit->category_uuid,
                'title' => $edit->title,
                'price' => $edit->price,
                'description' => $edit->description,
                'metadata' => $edit->metadata,
            ],
            $this->getAuthorizationHeader($this->user)
        );

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonMissingValidationErrors()
            ->assertJsonPath('success', 1);

        $this->assertDatabaseHas(self::TABLE, [
            'category_uuid' => $edit->category_uuid,
            'title' => $edit->title,
            'price' => $edit->price,
            'description' => $edit->description,
            'metadata' => $edit->metadata,
        ]);
    }

    /**
     * Checks if user can update a product
     *
     * @test
     */
    public function user_cannot_update_a_non_existing_product(): void
    {
        $product = Product::factory()->make();

        $this->assertDatabaseMissing(self::TABLE, [
            'category_uuid' => $product->category_uuid,
            'title' => $product->title,
            'price' => $product->price,
            'description' => $product->description,
            'metadata' => $product->metadata,
        ]);

        $response = $this->put(
            route('product.update', ['product' => 'uuid-not-exists']),
            [
                'category_uuid' => $product->category_uuid,
                'title' => $product->title,
                'price' => $product->price,
                'description' => $product->description,
                'metadata' => $product->metadata,
            ],
            $this->getAuthorizationHeader($this->user)
        );

        $response->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJsonMissingValidationErrors()
            ->assertJsonPath('success', 0);
    }

    /**
     * Can show product without any authorization
     *
     * @test
     */
    public function can_show_product_without_authorization(): void
    {
        $product = Product::factory()->create();

        $response = $this->get(route('product.show', ['product' => $product->uuid]));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonMissingValidationErrors()
            ->assertJsonPath('success', 1);
    }

    /**
     * Can list all products without authorization.
     * The list is paginated therefore displaying current page.
     *
     * @test
     */
    public function can_list_all_products_without_authorization(): void
    {
        Product::factory(20)->create();

        $response = $this->get(route('products.index'));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonMissingValidationErrors()
            ->assertJsonPath('current_page', 1);
    }

    /**
     * Ensures that the product can be deleted
     *
     * @test
     */
    public function can_delete_a_product(): void
    {
        $product = Product::factory()->create();

        $response = $this->delete(
            route('product.destroy', ['product' => $product->uuid]),
            headers: $this->getAuthorizationHeader($this->user)
        );

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonMissingValidationErrors()
            ->assertJsonPath('success', 1);
    }

    /**
     * Ensures that the product cannot be deleted without authorization
     *
     * @test
     */
    public function cannot_delete_a_product_without_authorization(): void
    {
        $product = Product::factory()->create();

        $response = $this->delete(route('product.destroy', [
            'product' => $product->uuid,
        ]));

        $response->assertStatus(Response::HTTP_UNAUTHORIZED)
            ->assertJsonMissingValidationErrors();
    }
}
