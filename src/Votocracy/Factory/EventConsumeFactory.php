<?php

declare(strict_types=1);

namespace Votocracy\Factory;

use Votocracy\Handler\EventConsumeHandler;
use Common\Service\EventBusInterface;
use Psr\Container\ContainerInterface;

class EventConsumeFactory
{
    public function __invoke(ContainerInterface $container): EventConsumeHandler
    {
        return new EventConsumeHandler(
            $container->get(EventBusInterface::class)
        );
    }
}
