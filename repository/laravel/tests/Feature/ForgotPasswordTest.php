<?php

namespace Tests\Feature;

use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class ForgotPasswordTest extends TestCase
{
    use RefreshDatabase;

    public User $user;
    public const TABLE_NAME = 'password_resets';

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    /**
     * Creates a token to reset a user password
     *
     * @test
     */
    public function creates_a_token_to_reset_a_user_password(): void
    {
        $response = $this->triggerPasswordReset();

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonMissingValidationErrors()
            ->assertJsonPath('success', 1);
    }

    /**
     * Ensures that the user will always have one available token.
     * Previous tokens are deleted.
     *
     * @test
     */
    public function user_has_only_one_available_token_each_time(): void
    {
        $this->assertDatabaseCount(self::TABLE_NAME, 0);

        $this->triggerPasswordReset();

        $this->assertDatabaseCount(self::TABLE_NAME, 1);

        $this->triggerPasswordReset();

        $this->assertDatabaseCount(self::TABLE_NAME, 1);

        $this->triggerPasswordReset();

        $this->assertDatabaseCount(self::TABLE_NAME, 1);
    }

    /**
     * Ensures no token is generated for admin users.
     *
     * @test
     */
    public function does_not_generate_token_for_admin_users(): void
    {
        $user = User::factory()->admin()->create();

        $response = $this->post(route('user.forgot-pass'), [
            'email' => $user->email,
        ]);

        $response->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJsonMissingValidationErrors()
            ->assertJsonPath('success', 0);
    }

    private function triggerPasswordReset(): TestResponse
    {
        return $this->post(route('user.forgot-pass'), [
            'email' => $this->user->email,
        ]);
    }
}
