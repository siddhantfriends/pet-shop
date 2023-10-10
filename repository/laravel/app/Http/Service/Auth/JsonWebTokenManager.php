<?php

namespace App\Http\Service\Auth;

use App\Models\User;
use DateTimeImmutable;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Token\Parser;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Rsa\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Encoding\JoseEncoder;
use App\Http\Contracts\Auth\JsonWebToken;
use Lcobucci\JWT\Token\InvalidTokenStructure;
use Lcobucci\JWT\Encoding\CannotDecodeContent;
use Lcobucci\JWT\Token\UnsupportedHeaderFound;
use Lcobucci\JWT\UnencryptedToken;

class JsonWebTokenManager implements JsonWebToken
{
    protected Configuration $config;
    protected Builder $builder;

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

    public function parse(string $token): bool
    {
        try {
            $parser = new Parser(new JoseEncoder());
            $unencrypted = $parser->parse($token);

            assert($unencrypted instanceof UnencryptedToken);

            return true;
        } catch (CannotDecodeContent | InvalidTokenStructure | UnsupportedHeaderFound $e) {
            return false;
        }
    }

    public function validate(): void
    {
        //
    }
}
