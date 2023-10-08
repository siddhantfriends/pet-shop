<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Testing\TestResponse;
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
        $user = Arr::only(
            $user,
            [
                'first_name',
                'last_name',
                'email',
                'address',
                'phone_number',
            ]
        );

        $response = $this->post(
            '/api/v1/users/create',
            array_merge(
                $user,
                [
                    'password' => 'password',
                    'password_confirmation' => 'password',
                ]
            )
        );

        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * @test
     *
     * Cannot create user account without first name
     */
    public function cannot_create_user_account_without_first_name()
    {
        $response = $this->create_user_account_without('first_name');

        $response->assertJsonValidationErrorFor('first_name')
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * Creates user account without the given parameter
     */
    private function create_user_account_without(string $param): TestResponse
    {
        $user = User::factory()->make()->toArray();
        $user = Arr::except(
            Arr::only(
                $user,
                [
                    'first_name',
                    'last_name',
                    'email',
                    'address',
                    'phone_number',
                ]
            ),
            $param
        );

        $response = $this->post(
            '/api/v1/users/create',
            array_merge(
                $user,
                [
                    'password' => 'password',
                    'password_confirmation' => 'password',
                ]
            )
        );

        return $response;
    }
}
