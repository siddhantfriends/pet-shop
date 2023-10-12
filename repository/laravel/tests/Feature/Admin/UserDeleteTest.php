<?php

namespace Tests\Feature\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\Feature\BaseTestCase;
use Tests\TestCase;

class UserDeleteTest extends BaseTestCase
{
    /**
     * Admin can delete user account
     *
     * @test
     */
    public function admin_can_delete_user(): void
    {
        $response = $this->delete(
            route('admin.user-delete', ['user' => $this->user]),
            headers: $this->getAuthorizationHeader($this->admin)
        );

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonMissingValidationErrors()
            ->assertJsonPath('success', 1);
    }

    /**
     * User cannot delete user account
     *
     * @test
     */
    public function user_cannot_delete_user(): void
    {
        $response = $this->delete(
            route('admin.user-delete', ['user' => $this->user]),
            headers: $this->getAuthorizationHeader($this->user)
        );

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonMissingValidationErrors()
            ->assertJsonPath('success', 0);
    }
}
