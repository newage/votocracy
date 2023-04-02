<?php

declare(strict_types=1);

namespace Common\Annotation;

use Attribute;
use Laminas\Hydrator\HydrationInterface;

#[Attribute]
final class Hydrator implements AttributeHydratorInterface
{
    public function __construct(private readonly string $name)
    {
    }

    public function getHydrator(): HydrationInterface
    {
        return new $this->name();
    }
}
