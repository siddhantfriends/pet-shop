<?php

namespace Tests\Feature\User;

use App\Facades\JsonWebToken;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\Feature\BaseTestCase;
use Tests\TestCase;

class UpdateUserAccountTest extends TestCase
{
    use RefreshDatabase;

    /**
     * User can update his own account for example User A can only edit User A.
     *
     * @test
     */
    public function user_can_update_his_own_account_details(): void
    {
        $user = User::factory()->create();
        $editUser = User::factory()->make();

        $response = $this->put(
            route('user.update'),
            [
                'first_name' => $editUser->first_name,
                'last_name' => $editUser->last_name,
                'email' => $editUser->email,
                'password' => 'userpassword',
                'password_confirmation' => 'userpassword',
                'avatar' => $editUser->avatar,
                'address' => $editUser->address,
                'phone_number' => $editUser->phone_number,
                'is_marketing' => 0,
            ],
            ['Authorization' => 'Bearer ' . JsonWebToken::issue($user)],
        );

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonMissingValidationErrors()
            ->assertJsonPath('success', 1)
            ->assertJsonPath('data.email', $editUser->email);
    }
}
