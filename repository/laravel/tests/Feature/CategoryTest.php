<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class CategoryTest extends BaseTestCase
{
    use RefreshDatabase;

    public const TABLE = 'categories';

    /**
     * Checks if user can create category
     *
     * @test
     */
    public function user_can_create_category(): void
    {
        $category = Category::factory()->make();
        $response = $this->post(
            route('category.store'),
            ['title' => $category->title],
            $this->getAuthorizationHeader($this->user)
        );

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonMissingValidationErrors()
            ->assertJsonPath('success', 1);

        $this->assertDatabaseHas(self::TABLE, [
            'title' => $category->title,
        ]);
    }

    /**
     * Checks if user can update a category
     *
     * @test
     */
    public function user_can_update_a_category(): void
    {
        $category = Category::factory()->create();
        $edit = Category::factory()->make();

        $this->assertDatabaseHas(self::TABLE, [
            'title' => $category->title,
        ]);

        $response = $this->put(
            route('category.update', ['category' => $category->uuid]),
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
}
