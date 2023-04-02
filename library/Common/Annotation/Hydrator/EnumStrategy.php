<?php

declare(strict_types=1);

namespace Common\Annotation\Hydrator;

use Attribute;
use Laminas\Hydrator\Strategy\BackedEnumStrategy;
use Laminas\Hydrator\Strategy\NullableStrategy;

#[Attribute]
final class EnumStrategy implements StrategyInterface
{
    public function __construct(private readonly string $class)
    {
    }

    public function getStrategy(): \Laminas\Hydrator\Strategy\StrategyInterface
    {
        return new NullableStrategy(new BackedEnumStrategy($this->class));
    }
}
