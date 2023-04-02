<?php
declare(strict_types=1);

namespace App\Exception;

use Common\Exception\InfoExceptionInterface;
use JetBrains\PhpStorm\Pure;
use Mezzio\ProblemDetails\Exception\CommonProblemDetailsExceptionTrait;
use Mezzio\ProblemDetails\Exception\ProblemDetailsExceptionInterface;

class ValidationException extends \RuntimeException implements ProblemDetailsExceptionInterface, InfoExceptionInterface
{
    use CommonProblemDetailsExceptionTrait;

    #[Pure]
    public static function wrongParameter(string $message, array $details = []): self
    {
        $e = new self($message);
        $e->status = 400;
        $e->detail = $message;
        $e->type = 'https://httpstatuses.com/400';
        $e->title = 'Wrong parameter';
        $e->additional['transaction'] = $details;
        return $e;
    }
}
