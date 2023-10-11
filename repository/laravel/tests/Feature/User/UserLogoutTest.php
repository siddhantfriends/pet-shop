<?php

namespace Tests\Feature\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class UserLogoutTest extends TestCase
{
    /**
     * checks if user can logout
     *
     * @test
     */
    public function user_can_logout(): void
    {
        $response = $this->get(route('user.logout'));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonMissingValidationErrors()
            ->assertJsonPath('success', 1);
    }
}
