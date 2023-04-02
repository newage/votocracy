<?php

declare(strict_types=1);

use Laminas\Log;

/**
 * Write to the file
 * 'writer' => Laminas\Log\Writer\Stream::class,
 * 'parameters' => ['stream' => 'data/log']
 *
 * Write to the stream
 * 'writer' => Laminas\Log\Writer\Stream::class,
 * 'parameters' => ['stream' => 'php://output']
 *
 * Write to the stderr
 * 'writer' => Laminas\Log\Writer\Stream::class,
 * 'parameters' => ['stream' => 'php://stderr']
 *
 * Write to Syslog
 * 'writer' => Laminas\Log\Writer\Syslog::class,
 * 'parameters' => []
 *
 * Write to graylog
 * 'writer' => \Common\Log\Writer\Graylog::class,
 * 'parameters' => [
 *   'stream' => \Common\Log\Writer\Graylog::TRANSPORT_UDP,
 *   'mode' => $_ENV['GRAYLOG_HOST'],
 *   'port' => $_ENV['GRAYLOG_PORT']
 * ]
 *
 * Enabling error handler can to log PHP errors and intercept exceptions and write it to stderr.
 * Recommend errors log to stderr or syslog
 *
 * 'error-handler' => [
 *   'writer' => Log\Writer\Stream::class,
 *   'parameters' => ['php://stderr'],
 * ]
 */
return [
    'logging' => [
        'writer' => Log\Writer\Stream::class,
        'parameters' => [
            'stream' => 'data/log',
            'mode' => null,
            'port' => null,
        ]
    ],
    'error-handler' => [
        'writer' => Log\Writer\Stream::class,
        'parameters' => ['php://stderr'],
    ]
];
