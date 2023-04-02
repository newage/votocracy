<?php

declare(strict_types=1);

namespace Common\Annotation\Input\Filter;

use Attribute;
use Laminas\Filter\FilterInterface;

#[Attribute]
final class ToInt implements AttributeFilterInterface
{
    public function getFilter(): FilterInterface
    {
        return new \Laminas\Filter\ToInt();
    }
}
