<?php

declare(strict_types=1);

namespace App\Factory;

use App\Handler\ApplicationsPostHandler;
use App\InputFilter\ApplicationFilter;
use Laminas\InputFilter\InputFilterPluginManager;
use Mezzio\Hal\HalResponseFactory;
use Mezzio\Hal\ResourceGenerator;
use Psr\Container\ContainerInterface;

class ApplicationsPostHandlerFactory
{
    public function __invoke(ContainerInterface $container): ApplicationsPostHandler
    {
        $pluginManager = $container->get(InputFilterPluginManager::class);
        $inputFilter   = $pluginManager->get(ApplicationFilter::class);

        return new ApplicationsPostHandler(
            $container->get(ResourceGenerator::class),
            $container->get(HalResponseFactory::class),
            $inputFilter
        );
    }
}
