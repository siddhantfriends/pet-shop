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
}
