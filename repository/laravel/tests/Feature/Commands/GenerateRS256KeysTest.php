<?php

namespace Tests\Feature\Commands;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GenerateRS256KeysTest extends TestCase
{
    /**
     * Checks if jwt keys can be created.
     *
     * @test
     */
    public function can_execute_jwt_keys() {
        $this->artisan('app:reset-database')
            ->assertSuccessful();

        $this->assertFileExists(config('jwt.private'));
        $this->assertFileExists(config('jwt.public'));
    }
}
