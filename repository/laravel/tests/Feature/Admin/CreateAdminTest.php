<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateAdminTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     *
     * Checks if an admin user can be created using /api/v1/admin/create
     */
    public function create_an_admin_user_account(): void
    {
        $user = User::factory()->make()->toArray();
        $user = Arr::only(
            $user,
            [
                'first_name',
                'last_name',
                'email',
                'address',
                'phone_number',
                'avatar',
            ]
        );

        $response = $this->post(
            route('admin.create'),
            array_merge(
                $user,
                [
                    'password' => 'password',
                    'password_confirmation' => 'password',
                ]
            )
        );

        $response->assertHeader('access-control-allow-origin', '*')
            ->assertHeader('cache-control', 'no-cache, private')
            ->assertHeader('content-type', 'application/json');

        $response->assertStatus(Response::HTTP_OK);
    }
}
