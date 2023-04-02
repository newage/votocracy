<?php

declare(strict_types=1);

namespace App\Exception;

use Common\Exception\ErrorExceptionInterface;
use JetBrains\PhpStorm\Pure;
use Mezzio\ProblemDetails\Exception\CommonProblemDetailsExceptionTrait;
use Mezzio\ProblemDetails\Exception\ProblemDetailsExceptionInterface;

class ErrorException extends \RuntimeException implements ProblemDetailsExceptionInterface, ErrorExceptionInterface
{
    use CommonProblemDetailsExceptionTrait;

    #[Pure]
    public static function test(string $message, array $details): self
    {
        $e = new self($message);
        $e->status = 400;
        $e->detail = $message;
        $e->type = '/transcript/#test-exception';
        $e->title = 'Example for test exception';
        $e->additional['transaction'] = $details;
        return $e;
    }
}
