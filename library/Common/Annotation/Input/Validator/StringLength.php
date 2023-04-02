<?php

declare(strict_types=1);

namespace Common\Annotation\Input\Validator;

use Attribute;
use Laminas\Validator\ValidatorInterface;
use Laminas\Validator;

#[Attribute]
class StringLength implements AttributeValidatorInterface
{
    public function __construct(private readonly int $min, private readonly int $max)
    {
    }

    public function getValidator(array $options = []): ValidatorInterface
    {
        return new Validator\StringLength(['min' => $this->min, 'max' => $this->max]);
    }
}
