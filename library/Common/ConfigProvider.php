<?php

declare(strict_types=1);

namespace Common;

use Common\Listener;
use Common\Middleware;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;
use Laminas\Diagnostics\Runner\Runner;
use Mezzio\Authorization\Acl\LaminasAcl;
use Mezzio\Authorization\AuthorizationInterface;
use Mezzio\ProblemDetails\ProblemDetailsMiddleware;

class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     *
     * @return array{"dependencies": string[][][]}
     */
    #[Pure]
    #[ArrayShape(['dependencies' => "\string[][]"])]
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
        ];
    }

    /**
     * Returns the container dependencies
     *
     * @return array{"invokables": string[], "factories": string[], "delegators": string[][]}
     */
    #[ArrayShape(['invokables' => "string[]", 'factories' => "string[]", 'delegators' => "\string[][]"])]
    public function getDependencies(): array
    {
        return [
            'invokables' => [
                Runner::class => Runner::class,
                Listener\LoggingErrorListener::class => Listener\LoggingErrorListener::class,
                AuthorizationInterface::class => LaminasAcl::class,
                Middleware\TokenBasedUserMiddleware::class => Middleware\TokenBasedUserMiddleware::class,
            ],
            'factories'  => [
                Container\ConfigInterface::class => Factory\ConfigFactory::class,
                Service\RedisInterface::class => Factory\RedisFactory::class,
                Service\EventBusInterface::class => Factory\EventBusFactory::class,
                Handler\MetricsHandler::class => Factory\MetricsHandlerFactory::class,
                Middleware\LoggerMiddleware::class => Factory\LoggerMiddlewareFactory::class,
                Middleware\JwtMiddleware::class => Factory\JwtMiddlewareFactory::class,
                Middleware\AclMiddleware::class => Factory\AclMiddlewareFactory::class,
            ],
            'delegators' => [
                ProblemDetailsMiddleware::class => [
                    Factory\ErrorHandlerLoggingDelegatorFactory::class,
                ]
            ]
        ];
    }
}
