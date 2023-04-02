<?php

declare(strict_types=1);

namespace Votocracy\Factory;

use Votocracy\Handler\EventProduceHandler;
use Common\Service\EventBusInterface;
use Psr\Container\ContainerInterface;

class EventProduceFactory
{
    public function __invoke(ContainerInterface $container): EventProduceHandler
    {
        return new EventProduceHandler(
            $container->get(EventBusInterface::class)
        );
    }
}
