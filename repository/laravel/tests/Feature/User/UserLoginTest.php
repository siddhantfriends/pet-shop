<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class UserLoginTest extends TestCase
{
    use RefreshDatabase;

    /**
     * User can login with the correct password
     *
     * @test
     */
    public function user_can_login_with_correct_password(): void
    {
        $response = $this->post(route('user.login'), [
            'email' => $this->fetchUserEmailAddress(),
            'password' => 'userpassword',
        ]);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonMissingValidationErrors()
            ->assertJsonPath('success', 1);
    }

    /**
     * User cannot login with incorrect password
     *
     * @test
     */
    public function user_cannot_login_with_incorrect_password(): void
    {
        $response = $this->post(route('user.login'), [
            'email' => $this->fetchUserEmailAddress(),
            'password' => 'incorrect password',
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonMissingValidationErrors()
            ->assertJsonPath('success', 0);
    }

    /**
     * Admin cannot login to user with correct password
     *
     * @test
     */
    public function admin_cannot_login_to_user_with_correct_password(): void
    {
        $response = $this->post(route('user.login'), [
            'email' => $this->fetchUserEmailAddress(1),
            'password' => 'admin',
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonMissingValidationErrors()
            ->assertJsonPath('success', 0);
    }

    private function fetchUserEmailAddress(int $is_admin = 0): string
    {
        return User::whereIsAdmin($is_admin)->first()->email;
    }
}
