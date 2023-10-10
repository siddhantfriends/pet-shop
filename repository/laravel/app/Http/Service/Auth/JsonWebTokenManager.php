<?php

namespace App\Http\Service\Auth;

use App\Models\User;
use DateTimeImmutable;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Token\Parser;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\UnencryptedToken;
use Lcobucci\JWT\Signer\Rsa\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Encoding\JoseEncoder;
use Lcobucci\JWT\Validation\Validator;
use App\Http\Contracts\Auth\JsonWebToken;
use Lcobucci\JWT\Token\InvalidTokenStructure;
use Lcobucci\JWT\Encoding\CannotDecodeContent;
use Lcobucci\JWT\Token\UnsupportedHeaderFound;
use Illuminate\Validation\UnauthorizedException;
use Lcobucci\JWT\Validation\Constraint\IssuedBy;

class JsonWebTokenManager implements JsonWebToken
{
    protected Configuration $config;
    protected Builder $builder;
    protected Parser $parser;
    protected Validator $validator;

    public function __construct()
    {
        $this->config = Configuration::forAsymmetricSigner(
            new Sha256(),
            InMemory::file(config('jwt.private')),
            InMemory::file(config('jwt.public'))
        );

        $this->builder = $this->config->builder();
        $this->parser = new Parser(new JoseEncoder());
        $this->validator = new Validator();
    }

    public function issue(User $user, ?string $issuedBy = null, ?string $expiresAfter = null): string
    {
        $now = new DateTimeImmutable();

        $token = $this->builder->issuedBy($issuedBy ?? config('app.url'))
            ->expiresAt($now->modify($expiresAfter ?? config('jwt.expires_after')))
            ->withClaim('user_uuid', $user->uuid)
            ->getToken($this->config->signer(), $this->config->signingKey());

        return $token->toString();
    }

    public function parse(string $token): bool
    {
        $parsedToken = $this->parseToken($token);
        return assert($parsedToken instanceof UnencryptedToken);
    }

    public function validate(string $token): bool
    {
        $parsedToken = $this->parseToken($token);

        $now = new DateTimeImmutable();

        return !$parsedToken->isExpired($now) &&
            $parsedToken->claims()->has('user_uuid') &&
            $this->validator->validate(
                $parsedToken,
                new IssuedBy(config('app.url')),
            );
    }

    public function parseToken(string $token): UnencryptedToken
    {
        try {
            return $this->parser->parse($token);
        } catch (CannotDecodeContent | InvalidTokenStructure | UnsupportedHeaderFound $e) {
            throw new UnauthorizedException(previous: $e);
        }
    }
}
