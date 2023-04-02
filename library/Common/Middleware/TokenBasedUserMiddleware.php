<?php

declare(strict_types=1);

namespace Common\Middleware;

use Common\Data\UserInterface;
use Common\Data\Value\TokenBasedUser;
use Common\Exception\AuthorizationException;
use Lcobucci\JWT\Token\DataSet;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class TokenBasedUserMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $dataSet = $request->getAttribute(DataSet::class);
        if (!$dataSet->get('uid')) {
            throw AuthorizationException::invalidToken('Can not get parameter', ['parameter' => 'uid']);
        }
        if (!$dataSet->get('email')) {
            throw AuthorizationException::invalidToken('Can not get parameter', ['parameter' => 'email']);
        }
        if (!$dataSet->get('roles')) {
            throw AuthorizationException::invalidToken('Can not get parameter', ['parameter' => 'roles']);
        }

        return $handler->handle(
            $request->withAttribute(
                UserInterface::class,
                new TokenBasedUser($dataSet->get('uid'), $dataSet->get('email'), $dataSet->get('roles'))
            )
        );
    }
}
