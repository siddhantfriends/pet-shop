<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class ForgotPasswordTest extends TestCase
{
    /**
     * Creates a token to reset a user password
     *
     * @test
     */
    public function creates_a_token_to_reset_a_user_password(): void
    {
        $user = User::factory()->create();

        $response = $this->post(route('user.forgot-pass'), [
            'email' => $user->email,
        ]);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonMissingValidationErrors()
            ->assertJsonPath('success', 1);
    }
}
