<?php

namespace Tests\Feature;

use App\Facades\JsonWebToken;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JetBrains\PhpStorm\ArrayShape;
use Tests\TestCase;

abstract class BaseTestCase extends TestCase
{
    use RefreshDatabase;

    public User $admin;
    public User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();

        $this->registerUsers();
    }

    private function registerUsers(): void
    {
        $this->admin = $this->getUserAccount(1);
        $this->user = $this->getUserAccount(0);
    }

    private function getUserAccount($is_admin): User
    {
        return User::whereIsAdmin($is_admin)->first();
    }

    #[ArrayShape(['Authorization' => "string"])]
    public function getAuthorizationHeader(User $user): array
    {
        return ['Authorization' => 'Bearer ' . JsonWebToken::issue($user)];
    }
}
