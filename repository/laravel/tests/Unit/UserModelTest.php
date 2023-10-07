<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\TestCase;

class UserModelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     *
     * Checks if user is an admin
     */
    public function user_is_admin(): void
    {
        $user = User::factory()->admin()->create();

        $this->assertTrue(User::isAdmin());
    }
}
