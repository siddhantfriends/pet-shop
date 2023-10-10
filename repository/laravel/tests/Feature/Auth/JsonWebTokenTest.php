<?php

namespace Tests\Feature\Auth;

use App\Facades\JsonWebToken;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class JsonWebTokenTest extends TestCase
{
    use RefreshDatabase;

    protected string $token;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();

        $this->token = $this->issueToken();
    }

    /**
     * checks if the token can be issued
     *
     * @test
     */
    public function can_issue_json_web_token() {
        $this->assertNotEmpty($this->token);
    }

    /**
     * checks if the token can be parsed
     *
     * @test
     */
    public function can_parse_json_web_token() {
        $parsed = JsonWebToken::parse($this->token);

        $this->assertTrue($parsed);
    }

    private function issueToken(): string
    {
        return JsonWebToken::issue(User::first());
    }
}
