<?php

namespace Tests\Feature\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class AdminLogoutTest extends TestCase
{
    /**
     * checks if admin can logout
     *
     * @test
     */
    public function admin_can_logout(): void
    {
        $response = $this->get(route('admin.logout'));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonMissingValidationErrors()
            ->assertJsonPath('success', 1);
    }
}
