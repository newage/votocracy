<?php

declare(strict_types=1);

return [
    'redis' => [
        'host' => $_ENV['REDIS_HOST'] ?? 'redis',
        'port' => $_ENV['REDIS_PORT'] ?? 6379,
        'auth' => $_ENV['REDIS_AUTH'] ?? 'guest',
    ]
];
