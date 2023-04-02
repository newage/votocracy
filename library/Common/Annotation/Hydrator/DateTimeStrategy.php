<?php

declare(strict_types=1);

namespace Common\Annotation\Hydrator;

use Attribute;
use Laminas\Hydrator\Strategy\DateTimeFormatterStrategy;
use Laminas\Hydrator\Strategy\DateTimeImmutableFormatterStrategy;

#[Attribute]
final class DateTimeStrategy implements StrategyInterface
{
    public function __construct(private readonly string $format)
    {
    }

    public function getStrategy(): \Laminas\Hydrator\Strategy\StrategyInterface
    {
        return new DateTimeImmutableFormatterStrategy(
            new DateTimeFormatterStrategy($this->format)
        );
    }
}
