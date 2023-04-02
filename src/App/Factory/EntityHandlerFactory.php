<?php

declare(strict_types=1);

namespace App\Factory;

use App\Handler\EntityHandler;
use Mezzio\Hal\Renderer\JsonRenderer;
use Psr\Container\ContainerInterface;

class EntityHandlerFactory
{
    public function __invoke(ContainerInterface $container): EntityHandler
    {
        $renderer = $container->get(JsonRenderer::class);
        return new EntityHandler($renderer);
    }
}
