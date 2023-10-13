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

    /**
     * Checks if user can update a category
     *
     * @test
     */
    public function user_cannot_update_a_non_existing_category(): void
    {
        $category = Category::factory()->make();

        $this->assertDatabaseMissing(self::TABLE, [
            'title' => $category->title,
        ]);

        $response = $this->put(
            route('category.update', ['category' => 'uuid-not-exists']),
            ['title' => $category->title],
            $this->getAuthorizationHeader($this->user)
        );

        $response->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJsonMissingValidationErrors()
            ->assertJsonPath('success', 0);
    }

    /**
     * Can show category without any authorization
     *
     * @test
     */
    public function can_show_category_without_authorization(): void
    {
        $category = Category::factory()->create();

        $response = $this->get(route('category.show', ['category' => $category->uuid]));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonMissingValidationErrors()
            ->assertJsonPath('success', 1);
    }

    /**
     * Can list all categories without authorization.
     * The list is paginated therefore displaying current page.
     *
     * @test
     */
    public function can_list_all_categories_without_authorization(): void
    {
        Category::factory(20)->create();

        $response = $this->get(route('categories.index'));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonMissingValidationErrors()
            ->assertJsonPath('current_page', 1);
    }
}
