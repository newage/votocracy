<?php

declare(strict_types=1);

namespace Common\Factory;

use Common\Container\ConfigInterface;
use Common\Decorator\EmptyRedisDecorator;
use Common\Service\RedisInterface;
use Psr\Container\ContainerInterface;

class RedisFactory
{
    /**
     * @param ContainerInterface $container
     * @return RedisInterface
     */
    public function __invoke(ContainerInterface $container): RedisInterface
    {
        $config = $container->get(ConfigInterface::class);
        $redis = new EmptyRedisDecorator();
        $redis->connect($config->get('redis.host'), $config->get('redis.port'));
        $redis->auth($config->get('redis.auth'));
        return $redis;
    }
}
