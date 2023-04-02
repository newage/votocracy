<?php

declare(strict_types=1);

namespace Common\Annotation\Hydrator;

use Attribute;
use Laminas\Hydrator\HydratorInterface;
use Laminas\Hydrator\ReflectionHydrator;
use Laminas\Hydrator\Strategy\HydratorStrategy;

#[Attribute]
final class ReflectionStrategy implements StrategyInterface
{
    private ?HydratorInterface $reflectionHydrator = null;

    public function __construct(private readonly string $reflectionEntity)
    {
    }

    public function getReflectionEntity(): string
    {
        return $this->reflectionEntity;
    }


    public function setReflectionHydrator(HydratorInterface $reflectionHydrator)
    {
        $this->reflectionHydrator = $reflectionHydrator;
    }

    public function getStrategy(): \Laminas\Hydrator\Strategy\StrategyInterface
    {
        return new HydratorStrategy(
            $this->reflectionHydrator ?? new ReflectionHydrator(),
            $this->reflectionEntity
        );
    }
}
