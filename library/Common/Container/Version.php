<?php

declare(strict_types=1);

namespace Common\Container;

class Version
{
    private const DEFAULT_VERSION = '1';

    private string $version = self::DEFAULT_VERSION;

    /**
     * @param string $version
     */
    public function setVersion(string $version)
    {
        $this->version = $version;
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }
}
