<?php

declare(strict_types=1);

namespace Common\Annotation\Input\Filter;

use Attribute;
use Laminas\Filter\FilterInterface;
use Laminas\Filter;

#[Attribute]
final class Digits implements AttributeFilterInterface
{
    public function getFilter(): FilterInterface
    {
        return new Filter\Digits();
    }
}
