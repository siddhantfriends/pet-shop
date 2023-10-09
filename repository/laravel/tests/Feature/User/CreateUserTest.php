<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Http\Response;
use Illuminate\Testing\TestResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateUserTest extends TestCase
{
    use RefreshDatabase;

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
            route('user.create'),
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

    /**
     * @test
     *
     * Cannot create user account without mandatory fields
     */
    public function cannot_create_user_account_without_mandatory_fields()
    {
        // field => error field
        $fields = [
            'first_name' => 'first_name',
            'last_name' => 'last_name',
            'email' => 'email',
            'address' => 'address',
            'phone_number' => 'phone_number',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        array_walk($fields, function ($error, $field) {
            $this->create_user_account_without($field)
                ->assertJsonValidationErrorFor($error)
                ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        });
    }

    /**
     * Creates user account without the given parameter
     */
    private function create_user_account_without(string $param): TestResponse
    {
        $user = User::factory()->make()->toArray();

        $user = Arr::only($user, [
            'first_name',
            'last_name',
            'email',
            'address',
            'phone_number',
        ]);

        $user = array_merge($user, [
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response = $this->post(
            route('user.create'),
            Arr::except($user, $param),
        );

        return $response;
    }
}
