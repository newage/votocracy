<?php

declare(strict_types=1);

namespace Votocracy\Handler;

use Votocracy\Exception\ErrorException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class LoggingHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        throw ErrorException::test('Test error message', ['income' => 'data']);
    }
}
