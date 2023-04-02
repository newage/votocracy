<?php

declare(strict_types=1);

use Laminas\Diagnostics\Check;

return [
    'prometheus' => [
        'serviceName' => $_ENV['SERVICE_NAME'] ?? 'mezzio',
    ],
    'diagnostics' => [
        /* Name for checker. <prefix>_METRIC_<suffix> */
        'redis' => [
            /* Prefix. like (service|handle|library|external_service) PREFIX_<metric>_<suffix> */
            'prefix' => 'service',
            /* Suffix. like (life|total|seconds|etc.) <prefix>_<metric>_SUFFIX */
            'suffix' => 'life',
            /* Checker class */
            'checker' => Check\Redis::class,
            /* Parameters for checker's constructor */
            'parameters' => [
                $_ENV['REDIS_HOST'] ?? 'redis',
                $_ENV['REDIS_PORT'] ?? 6379,
                $_ENV['REDIS_AUTH'] ?? 'guest'
            ],
        ]
    ]
];
