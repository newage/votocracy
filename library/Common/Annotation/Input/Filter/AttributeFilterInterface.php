<?php

namespace Common\Annotation\Input\Filter;

use Common\Annotation\AttributeInputFilterInterface;
use Laminas\Filter\FilterInterface;

interface AttributeFilterInterface extends AttributeInputFilterInterface
{
    public function getFilter(): FilterInterface;
}
