<?php

namespace App\Http\Service\Auth;

use App\Models\User;
use DateTimeImmutable;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\OpenSSL;
use Lcobucci\JWT\Signer\Rsa\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use App\Http\Contracts\Auth\JsonWebToken;

class JWTService implements JsonWebToken
{
    protected OpenSSL $algorithm;
    protected Configuration $config;
    protected Builder $builder;
    protected InMemory $signingKey;

    public function __construct()
    {
        $this->config = Configuration::forAsymmetricSigner(
            new Sha256(),
            InMemory::file(config('jwt.private')),
            InMemory::file(config('jwt.public'))
        );

        $this->builder = $this->config->builder();
    }

    public function issue(User $user): string
    {
        $now = new DateTimeImmutable();

        $token = $this->builder->issuedBy(config('app.url'))
            ->expiresAt($now->modify(config('jwt.expires_after')))
            ->withClaim('user_uuid', $user->uuid)
            ->getToken($this->config->signer(), $this->config->signingKey());

        return $token->toString();
    }

    public function parse(): void
    {
        //
    }

    public function validate(): void
    {
        //
    }
}
