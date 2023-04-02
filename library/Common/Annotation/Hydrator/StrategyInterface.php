<?php

namespace Common\Annotation\Hydrator;

use Common\Annotation\AttributeHydratorInterface;

interface StrategyInterface extends AttributeHydratorInterface
{
    public function getStrategy(): \Laminas\Hydrator\Strategy\StrategyInterface;
}
