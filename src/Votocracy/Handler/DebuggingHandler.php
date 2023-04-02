<?php

declare(strict_types=1);

namespace Votocracy\Handler;

use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

class DebuggingHandler implements RequestHandlerInterface
{
    public function __construct(private readonly LoggerInterface $logger)
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $logger = $request->getAttribute(LoggerInterface::class);
        $logger->log(LogLevel::DEBUG, 'Debug message via logger from request attribute', ['parameters' => 'data']);

        $this->logger->log(LogLevel::DEBUG, 'Debug message via logger from constructor', ['parameters' => 'data']);

        return new JsonResponse(['response' => 'ok']);
    }
}
