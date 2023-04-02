<?php

declare(strict_types=1);

namespace Common\Factory;

use Common\Middleware\AclMiddleware;
use Mezzio\Authorization\AuthorizationInterface;
use Psr\Container\ContainerInterface;

class AclMiddlewareFactory
{
    public function __invoke(ContainerInterface $container): AclMiddleware
    {
        return new AclMiddleware($container->get(AuthorizationInterface::class));
    }
}
