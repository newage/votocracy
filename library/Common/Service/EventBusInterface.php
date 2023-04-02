<?php

namespace Common\Service;

interface EventBusInterface
{
    public function produce(string $message, array $headers = null): int;

    public function consume(callable $process);
}
