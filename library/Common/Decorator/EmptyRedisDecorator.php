<?php

declare(strict_types=1);

namespace Common\Decorator;

use Common\Service\RedisInterface;

class EmptyRedisDecorator extends \Redis implements RedisInterface
{
}
