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
     * Cannot create user account without mandatory fields
     */
    public function cannot_create_user_account_without_mandatory_fields()
    {
        $fields = [
            'first_name',
            'last_name',
            'email',
            'address',
            'phone_number',
            'password',
            'password_confirmation',
        ];

        array_walk($fields, function ($field) {
            $response = $this->create_user_account_without($field);

            $response->assertJsonValidationErrorFor($field)
                ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        });
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
