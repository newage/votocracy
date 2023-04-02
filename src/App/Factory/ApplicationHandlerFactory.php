<?php

declare(strict_types=1);

namespace App\Factory;

use App\Handler\ApplicationHandler;
use Mezzio\Hal\HalResponseFactory;
use Mezzio\Hal\ResourceGenerator;
use Psr\Container\ContainerInterface;

class ApplicationHandlerFactory
{
    public function __invoke(ContainerInterface $container): ApplicationHandler
    {
        return new ApplicationHandler(
            $container->get(ResourceGenerator::class),
            $container->get(HalResponseFactory::class)
        );
    }
}
