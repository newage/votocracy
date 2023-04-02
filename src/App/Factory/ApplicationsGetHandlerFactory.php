<?php

declare(strict_types=1);

namespace App\Factory;

use App\Handler\ApplicationsGetHandler;
use Mezzio\Hal\HalResponseFactory;
use Mezzio\Hal\ResourceGenerator;
use Psr\Container\ContainerInterface;

class ApplicationsGetHandlerFactory
{
    public function __invoke(ContainerInterface $container): ApplicationsGetHandler
    {
        return new ApplicationsGetHandler(
            $container->get(ResourceGenerator::class),
            $container->get(HalResponseFactory::class)
        );
    }
}
