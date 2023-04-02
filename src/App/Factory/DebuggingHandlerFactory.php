<?php

declare(strict_types=1);

namespace App\Factory;

use App\Handler\DebuggingHandler;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

class DebuggingHandlerFactory
{
    public function __invoke(ContainerInterface $container): DebuggingHandler
    {
        $logger = $container->get(LoggerInterface::class);
        return new DebuggingHandler($logger);
    }
}
