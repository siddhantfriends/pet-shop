<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\Feature\BaseTestCase;
use Tests\TestCase;

class UserListingTest extends BaseTestCase
{
    /**
     * Admin can view admin user listing
     *
     * @test
     */
    public function admin_can_list_all_users()
    {
        $response = $this->get(
            route('admin.user-listing'),
            $this->getAuthorizationHeader($this->admin)
        );

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonMissingValidationErrors()
            ->assertJsonPath('current_page', 1);
    }

    /**
     * User cannot view admin user listing
     *
     * @test
     */
    public function user_cannot_list_all_users()
    {
        $response = $this->get(
            route('admin.user-listing'),
            $this->getAuthorizationHeader($this->user)
        );

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonMissingValidationErrors();
    }

    /**
     * Admin can filter users with params
     *
     * @test
     */
    public function admin_can_filter_users_with_params()
    {
        User::factory()->create([
            'first_name' => 'Augustine',
            'last_name' => 'Schroeder',
        ]);

        $response = $this->get(
            route(
                'admin.user-listing',
                [
                    'first_name' => 'August',
                ]
            ),
            $this->getAuthorizationHeader($this->admin),
        );

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonMissingValidationErrors()
            ->assertJsonPath('current_page', 1)
            ->assertJsonPath('data.0.first_name', 'Augustine');
    }
}
