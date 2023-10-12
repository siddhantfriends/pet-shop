<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\Feature\BaseTestCase;
use Tests\TestCase;

class UserEditTest extends BaseTestCase
{
    /**
     * Admin can edit user details
     *
     * @test
     */
    public function admin_can_edit_user_details(): void
    {
        $editUser = User::factory()->make();

        $response = $this->put(
            route('admin.user-edit', ['user' => $this->user->uuid]),
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
            $this->getAuthorizationHeader($this->admin)
        );

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonMissingValidationErrors()
            ->assertJsonPath('success', 1)
            ->assertJsonPath('data.email', $editUser->email);
    }

    /**
     * User cannot edit user details
     *
     * @test
     */
    public function user_cannot_edit_user_details(): void
    {
        $editUser = User::factory()->make();

        $response = $this->put(
            route('admin.user-edit', ['user' => $this->user->uuid]),
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
            $this->getAuthorizationHeader($this->user)
        );

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonMissingValidationErrors()
            ->assertJsonPath('success', 0);
    }
}
