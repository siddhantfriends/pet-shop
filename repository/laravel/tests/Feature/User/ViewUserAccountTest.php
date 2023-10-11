<?php

namespace Tests\Feature\User;

use App\Facades\JsonWebToken;
use App\Models\User;
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

    private function issueToken(): string
    {
        return JsonWebToken::issue($this->user);
    }
}
