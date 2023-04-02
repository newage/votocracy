<?php

declare(strict_types=1);

namespace Common\Factory;

use Common\Container\ConfigInterface;
use Common\Service\EventBusInterface;
use Common\Service\EventBusService;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

class EventBusFactory
{
    public function __invoke(ContainerInterface $container): EventBusInterface
    {
        return new EventBusService(
            $container->get(ConfigInterface::class),
            $container->get(LoggerInterface::class)
        );
    }
}
