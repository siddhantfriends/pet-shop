<?php

namespace Tests\Feature;

use App\Jobs\ResetPasswordTokenCleanupJob;
use App\Models\PasswordReset;
use App\Models\User;
use Bus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class ResetPasswordTest extends TestCase
{
    use RefreshDatabase;

    public User $user;
    public PasswordReset $reset;
    public const TABLE_NAME = 'password_resets';

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->reset = PasswordReset::factory()->create([
            'email' => $this->user->email,
        ]);
    }

    /**
     * Ensures that a user password can be reset with a reset password token
     *
     * @test
     */
    public function reset_a_user_password_with_a_token(): void
    {
        Bus::fake();

        $this->assertDatabaseHas(self::TABLE_NAME, [
            'email' => $this->user->email,
            'token' => $this->reset->token,
        ]);

        $response = $this->post(route('user.reset-pass-token'), [
            'token' => $this->reset->token,
            'email' => $this->user->email,
            'password' => 'userpassword',
            'password_confirmation' => 'userpassword',
        ]);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonMissingValidationErrors()
            ->assertJsonPath('success', 1);

        Bus::assertDispatchedAfterResponse(
            ResetPasswordTokenCleanupJob::class,
            function (ResetPasswordTokenCleanupJob $job) {
                $job->handle();
                return true;
        });

        $this->assertDatabaseCount(self::TABLE_NAME, 0);
    }

    /**
     * Ensures admin password cannot be reset with a user token
     *
     * @test
     */
    public function cannot_reset_admin_password_with_user_token(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->post(route('user.reset-pass-token'), [
            'token' => $this->reset->token,
            'email' => $admin->email,
            'password' => 'admin',
            'password_confirmation' => 'admin',
        ]);

        $response->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJsonMissingValidationErrors()
            ->assertJsonPath('success', 0);
    }

    /**
     * Ensures that User B cannot maliciously reset password from
     * User A's token.
     *
     * @test
     */
    public function cannot_reset_user_b_password_with_user_a_token(): void
    {
        $userB = User::factory()->create();

        $response = $this->post(route('user.reset-pass-token'), [
            'token' => $this->reset->token,
            'email' => $userB->email,
            'password' => 'userpassword',
            'password_confirmation' => 'userpassword',
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonMissingValidationErrors()
            ->assertJsonPath('success', 0);
    }
}
