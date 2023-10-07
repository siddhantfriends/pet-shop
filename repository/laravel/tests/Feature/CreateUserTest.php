<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateUserTest extends TestCase
{
    /**
     * @test
     *
     * Checks if a user can be created using /api/v1/user/create
     */
    public function create_a_user_account(): void
    {
        $user = User::factory()->make([
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response = $this->post('/api/v1/user/create', $user->only(
            'first_name', 'last_name', 'email', 'password',
            'password_confirmation', 'address', 'phone_number',
        ));

        $response->assertStatus(200);
    }
}
