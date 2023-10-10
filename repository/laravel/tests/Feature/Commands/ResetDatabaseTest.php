<?php

namespace Tests\Feature\Commands;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ResetDatabaseTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Tests the app reset database command
     * @test
     */
    public function can_execute_reset_database(): void
    {
        $this->artisan('app:reset-database')
            ->assertSuccessful();

        $admin = 1;
        $totalUsers = $admin + config('pet-shop.seeder.users');

        $this->assertDatabaseCount(User::class, $totalUsers);
    }
}
