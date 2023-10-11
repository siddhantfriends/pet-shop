<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class AdminLoginTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    /**
     * User can login with the correct password
     *
     * @test
     */
    public function user_can_login_with_correct_password(): void
    {
        $response = $this->post(route('admin.login'), [
            'email' => $this->fetchUserEmailAddress(),
            'password' => 'admin',
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
        $response = $this->post(route('admin.login'), [
            'email' => $this->fetchUserEmailAddress(),
            'password' => 'incorrect password',
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonMissingValidationErrors()
            ->assertJsonPath('success', 0);
    }

    /**
     * User cannot login to admin with correct password
     *
     * @test
     */
    public function user_cannot_login_to_admin_with_correct_password(): void
    {
        $response = $this->post(route('admin.login'), [
            'email' => $this->fetchUserEmailAddress(0),
            'password' => 'userpassword',
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonMissingValidationErrors()
            ->assertJsonPath('success', 0);
    }

    private function fetchUserEmailAddress(int $is_admin = 1): string
    {
        return User::whereIsAdmin($is_admin)->first()->email;
    }
}
