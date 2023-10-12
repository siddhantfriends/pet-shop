<?php

namespace Tests\Feature\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\Feature\BaseTestCase;
use Tests\TestCase;

class UserListingTest extends BaseTestCase
{
    /**
     * Admin can view user listing
     *
     * @test
     */
    public function admin_can_list_all_users()
    {
        $response = $this->get(
            route('admin.user-listing'),
            $this->getAuthorizationHeader($this->admin)
        );

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonMissingValidationErrors()
            ->assertJsonPath('success', 1);
    }
}
