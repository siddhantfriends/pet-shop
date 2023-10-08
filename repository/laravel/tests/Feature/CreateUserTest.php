<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
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
        $user = User::factory()->make()->toArray();
        $user = Arr::only($user, [
            'first_name', 'last_name', 'email', 'address', 'phone_number',
        ]);

        $response = $this->post('/api/v1/users/create', array_merge($user, [
            'password' => 'password',
            'password_confirmation' => 'password',
        ]));

        $response->assertStatus(200);
    }
}
