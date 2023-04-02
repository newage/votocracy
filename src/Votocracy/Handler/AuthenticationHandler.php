<?php

declare(strict_types=1);

namespace Votocracy\Handler;

use Common\Container\ConstantInterface;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AuthenticationHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $jwt = $request->getAttribute(ConstantInterface::MIDDLEWARE_JWT);

        return new JsonResponse([
            'authentication' => 'ok',
            'uid' => $jwt->get('uid')
        ]);
    }
}
