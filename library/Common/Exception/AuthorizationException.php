<?php

declare(strict_types=1);

namespace Common\Exception;

use JetBrains\PhpStorm\Pure;
use Mezzio\ProblemDetails\Exception\CommonProblemDetailsExceptionTrait;
use Mezzio\ProblemDetails\Exception\ProblemDetailsExceptionInterface;

class AuthorizationException extends \RuntimeException implements
    ProblemDetailsExceptionInterface,
    InfoExceptionInterface
{
    use CommonProblemDetailsExceptionTrait;

    #[Pure]
    public static function forbidden(string $message, array $details = []): self
    {
        $e = new self($message);
        $e->status = 403;
        $e->detail = $message;
        $e->type = 'https://httpstatuses.com/403';
        $e->title = 'Forbidden';
        $e->additional['transaction'] = $details;
        return $e;
    }

    #[Pure]
    public static function invalidToken(string $message, array $details = []): self
    {
        $e = new self($message);
        $e->status = 401;
        $e->detail = $message;
        $e->type = 'https://httpstatuses.com/403';
        $e->title = 'Invalid JWT';
        $e->additional['transaction'] = $details;
        return $e;
    }

    #[Pure]
    public static function invalidHeader(string $message, array $details = []): self
    {
        $e = new self($message);
        $e->status = 401;
        $e->detail = $message;
        $e->type = 'https://httpstatuses.com/403';
        $e->title = 'Invalid authorization header';
        $e->additional['transaction'] = $details;
        return $e;
    }
}
