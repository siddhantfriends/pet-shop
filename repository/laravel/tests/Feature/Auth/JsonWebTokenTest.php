<?php

namespace Tests\Feature\Auth;

use App\Facades\JsonWebToken;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Validation\UnauthorizedException;
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
    public function can_issue_json_web_token(): void
    {
        $this->assertNotEmpty($this->token);
    }

    /**
     * checks if the token can be parsed
     *
     * @test
     */
    public function can_parse_json_web_token(): void
    {
        $parsed = JsonWebToken::parse($this->token);

        $this->assertTrue($parsed);
    }

    /**
     * check if parser fails on invalid token
     *
     * @test
     */
    public function parser_fails_on_invalid_token(): void
    {
        $parsed = 'invalid token';

        $this->assertThrows(function () use ($parsed) {
            JsonWebToken::parse($parsed);
        }, UnauthorizedException::class);
    }

    /**
     * check if the token can be verified
     *
     * @test
     */
    public function can_validate_json_web_token(): void
    {
        $this->assertTrue(JsonWebToken::validate($this->token));
    }

    /**
     * Validate should return false for expired tokens
     *
     * @test
     */
    public function validate_returns_false_for_expired_token(): void
    {
        $expiredToken = JsonWebToken::issue(User::first(), expiresAfter: '-10 minutes');

        $validated = JsonWebToken::validate($expiredToken);

        $this->assertFalse($validated);
    }

    /**
     * Validation fails for invalid server domains
     *
     * @test
     */
    public function validation_fails_for_invalid_server_domain(): void
    {
        $invalidServerDomain = JsonWebToken::issue(User::first(), issuedBy: 'https://example.com');

        $validated = JsonWebToken::validate($invalidServerDomain);

        $this->assertFalse($validated);
    }

    private function issueToken(): string
    {
        return JsonWebToken::issue(User::first());
    }
}
