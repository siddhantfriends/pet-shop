<?php

namespace Tests\Feature\User;

use App\Facades\JsonWebToken;
use App\Models\User;
use Illuminate\Http\Response;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ViewUserAccountTest extends TestCase
{
    use RefreshDatabase;

    public User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate:fresh');
        $this->seed();

        $this->user = User::where('is_admin', 0)->first();
    }

    /**
     * User can view user account from /api/v1/user
     *
     * @test
     */
    public function can_view_user_account(): void
    {
        $response = $this->withHeaders(['Authorization'=>'Bearer '. $this->issueToken()])
            ->get(route('user.account'));

        $response->assertSuccessful();

        $response->assertJsonPath('data.uuid', $this->user->uuid);
    }

    /**
     * Unauthorized for invalid token
     */
    public function cannot_view_user_account_for_invalid_token(): void
    {
        $response = $this->withHeaders(['Authorization'=>'Bearer '. 'invalid-token'])
            ->get(route('user.account'));

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    private function issueToken(): string
    {
        return JsonWebToken::issue($this->user);
    }
}
