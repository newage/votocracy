<?php

declare(strict_types=1);

namespace Votocracy\Exception;

use Common\Exception\InfoExceptionInterface;
use JetBrains\PhpStorm\Pure;
use Mezzio\ProblemDetails\Exception\CommonProblemDetailsExceptionTrait;
use Mezzio\ProblemDetails\Exception\ProblemDetailsExceptionInterface;

class NotFoundException extends \RuntimeException implements ProblemDetailsExceptionInterface, InfoExceptionInterface
{
    use CommonProblemDetailsExceptionTrait;

    #[Pure]
    public static function user(string $message, array $details): self
    {
        $e = new self($message);
        $e->status = 404;
        $e->detail = $message;
        $e->type = '/transcript/#not-found-user-exception';
        $e->title = 'Not found user';
        $e->additional['transaction'] = $details;
        return $e;
    }

    #[Pure]
    public static function application(string $message, array $details): self
    {
        $e = new self($message);
        $e->status = 404;
        $e->detail = $message;
        $e->type = '/transcript/#not-found-application-exception';
        $e->title = 'Not found application';
        $e->additional['transaction'] = $details;
        return $e;
    }
}
