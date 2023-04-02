<?php

declare(strict_types=1);

namespace Votocracy;

use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;
use Laminas\ServiceManager\Factory\InvokableFactory;

/**
 * The configuration provider for the App module
 *
 * @see https://docs.laminas.dev/laminas-component-installer/
 */
class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     *
     * @return array{"dependencies": string[][]}
     */
    #[Pure]
    #[ArrayShape(['dependencies' => "\string[][]", 'input_filters' => "\string[][]"])]
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
        ];
    }

    /**
     * Returns the container dependencies
     * @return array{"invokables": string[], "factories": string[]}
     */
    #[ArrayShape(['invokables' => "string[]", 'factories' => "string[]"])]
    public function getDependencies(): array
    {
        return [
            'invokables' => [
                Handler\PingHandler::class => Handler\PingHandler::class,
                Handler\LoggingHandler::class => Handler\LoggingHandler::class,
                Handler\AuthenticationHandler::class => Handler\AuthenticationHandler::class,
            ],
            'factories'  => [
                Handler\DebuggingHandler::class => Factory\DebuggingHandlerFactory::class,
                Handler\UserHandler::class => Factory\UserHandlerFactory::class,
                Handler\EventProduceHandler::class => Factory\EventProduceFactory::class,
                Handler\EventConsumeHandler::class => Factory\EventConsumeFactory::class,
            ],
        ];
    }
}
