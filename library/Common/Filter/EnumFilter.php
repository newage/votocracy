<?php

declare(strict_types=1);

namespace Common\Filter;

use Laminas\Filter\AbstractFilter;

class EnumFilter extends AbstractFilter
{
    protected $options = [
        'enumType' => null
    ];

    public function __construct($options = null)
    {
        $this->options = $options;
    }

    public function filter($value)
    {
        if (is_string($value) || is_numeric($value)) {
            return $this->options['enumType']::tryFrom($value) ?? $value;
        }
        return $value;
    }
}
