<?php

declare(strict_types=1);

namespace Common\Container;

use JetBrains\PhpStorm\Pure;

class Config implements ConfigInterface
{
    private const DELIMITER = '.';

    public function __construct(private readonly array $config)
    {
    }

    public function get($keyString, $default = null)
    {
        $keys = explode(self::DELIMITER, $keyString);
        $value = $this->config;

        foreach ($keys as $key) {
            if (is_array($value)) {
                $value = $this->getValue($key, $value);
            }
            if ($value === null) {
                $value = $default;
            }
        }
        return $value;
    }

    protected function getValue($key, array $config)
    {
        if (array_key_exists($key, $config)) {
            return $config[$key];
        }
        return null;
    }
}
