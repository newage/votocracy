<?php

declare(strict_types=1);

namespace Votocracy\Factory;

use Votocracy\Handler\UserHandler;
use Mezzio\Hal\HalResponseFactory;
use Mezzio\Hal\ResourceGenerator;
use Psr\Container\ContainerInterface;

class UserHandlerFactory
{
    public function __invoke(ContainerInterface $container): UserHandler
    {
        return new UserHandler(
            $container->get(ResourceGenerator::class),
            $container->get(HalResponseFactory::class)
        );
    }
}
