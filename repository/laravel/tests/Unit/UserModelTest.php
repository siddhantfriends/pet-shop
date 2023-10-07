<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserModelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     *
     * Checks if user is an admin
     */
    public function user_is_an_admin(): void
    {
        $user = User::factory()->admin()->create();

        $this->assertTrue($user->isAdmin());
    }
}
