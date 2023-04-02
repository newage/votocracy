<?php

declare(strict_types=1);

namespace Common\Annotation\Hydrator;

use Attribute;
use Laminas\Hydrator\Strategy\ScalarTypeStrategy as ScalarStrategy;

#[Attribute]
final class ScalarTypeStrategy implements StrategyInterface
{
    public function __construct(private readonly string $toType)
    {
    }

    public function getStrategy(): \Laminas\Hydrator\Strategy\StrategyInterface
    {
        return match ($this->toType) {
            'int' => ScalarStrategy::createToInt(),
            'float' => ScalarStrategy::createToFloat(),
            'string' => ScalarStrategy::createToString(),
            'boolean' => ScalarStrategy::createToBoolean()
        };
    }
}
