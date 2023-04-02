<?php

declare(strict_types=1);

namespace Common\Exception;

use JetBrains\PhpStorm\Pure;
use Mezzio\ProblemDetails\Exception\CommonProblemDetailsExceptionTrait;
use Mezzio\ProblemDetails\Exception\ProblemDetailsExceptionInterface;

class CriticalException extends \RuntimeException implements
    ProblemDetailsExceptionInterface,
    CriticalExceptionInterface
{
    use CommonProblemDetailsExceptionTrait;

    #[Pure]
    public static function unknownGraylogTransport(string $message, array $details = []): self
    {
        $e = new self($message);
        $e->status = 500;
        $e->detail = $message;
        $e->type = 'https://httpstatuses.com/500';
        $e->title = 'Unknown the GrayLog transport';
        $e->additional['transaction'] = $details;
        return $e;
    }

    #[Pure]
    public static function entityHydrator(string $message, array $details = []): self
    {
        $e = new self($message);
        $e->status = 500;
        $e->detail = $message;
        $e->type = 'https://httpstatuses.com/500';
        $e->title = 'Critical hydrator for entity';
        $e->additional['transaction'] = $details;
        return $e;
    }

    #[Pure]
    public static function wrongInitialisation(string $message, array $details = []): self
    {
        $e = new self($message);
        $e->status = 500;
        $e->detail = $message;
        $e->type = 'https://httpstatuses.com/500';
        $e->title = 'Wrong initialisation';
        $e->additional['transaction'] = $details;
        return $e;
    }
}
