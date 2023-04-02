<?php

declare(strict_types=1);

namespace Common\Middleware;

use Common\Exception\AuthorizationException;
use Lcobucci\JWT\Token;
use Mezzio\Authorization\AuthorizationInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AclMiddleware implements MiddlewareInterface
{
    private const CURRENT_ROLE_ADMINISTRATOR = 'administrator';
    private const CURRENT_ROLE_USER = 'user';
    private const CURRENT_ROLE_TESTS = 'tests';

    public function __construct(readonly private AuthorizationInterface $acl)
    {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $dataSet = $request->getAttribute(Token\DataSet::class);
        if (!$dataSet instanceof Token\DataSet) {
            throw AuthorizationException::forbidden('Can not get dataset from JWT');
        }
        if (!$this->acl->isGranted($this->convertRolesToCurrentRole($dataSet->get('roles')), $request)) {
            throw AuthorizationException::forbidden('This user have a wrong role to get access to the resource');
        }

        return $handler->handle($request);
    }

    private function convertRolesToCurrentRole(array $roles): string
    {
        foreach ($roles as $roleName) {
            $foundRole = match ($roleName) {
                'ROLE_ADMIN' => self::CURRENT_ROLE_ADMINISTRATOR,
                'ROLE_USER' => self::CURRENT_ROLE_USER,
                'tests' => self::CURRENT_ROLE_TESTS,
                default => null
            };
            if ($foundRole) {
                return $foundRole;
            }
        }
        throw AuthorizationException::forbidden('Unregistered role in `solius`');
    }
}
