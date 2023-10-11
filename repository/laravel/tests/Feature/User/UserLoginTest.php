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
            'email' => $this->fetchNonAdminEmailAddress(),
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
            'email' => $this->fetchNonAdminEmailAddress(),
            'password' => 'incorrect password',
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonMissingValidationErrors()
            ->assertJsonPath('success', 0);
    }

    private function fetchNonAdminEmailAddress(): string
    {
        return User::whereIsAdmin(0)->first()->email;
    }
}
