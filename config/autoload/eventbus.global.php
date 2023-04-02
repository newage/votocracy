<?php

declare(strict_types=1);

return [
    'eventbus' => [
        'kafka' => [
            'broker' => $_ENV['KAFKA_SERVERS'],
            'topic' => $_ENV['KAFKA_TOPIC_NAME_FOR_MESSAGE_BUS'],
            'producer' => [
                'attempts' => 10,
                'config' => [
                    'bootstrap.servers' => $_ENV['KAFKA_SERVERS'],
                    'security.protocol' => 'SASL_SSL',
                    'sasl.mechanism' => 'SCRAM-SHA-256',
                    'sasl.username' => $_ENV['KAFKA_USERNAME'],
                    'sasl.password' => $_ENV['KAFKA_PASSWORD'],
                    'api.version.request' => 'false',
                    'log_level' => (string)LOG_DEBUG,
                    'debug' => 'all',
                ]
            ],
            'consumer' => [
                'config' => [
                    'bootstrap.servers' => $_ENV['KAFKA_SERVERS'],
                    'security.protocol' => 'SASL_SSL',
                    'sasl.mechanism' => 'SCRAM-SHA-256',
                    'sasl.username' => $_ENV['KAFKA_USERNAME'],
                    'sasl.password' => $_ENV['KAFKA_PASSWORD'],
                    'api.version.request' => 'false',
                    'socket.keepalive.enable' => 'true',
                    'group.id' => $_ENV['SERVICE_NAME'],
                    'auto.offset.reset' => 'earliest',
                    'log_level' => (string)LOG_DEBUG,
                    'debug' => 'all',
                ]
            ]
        ]
    ]
];
