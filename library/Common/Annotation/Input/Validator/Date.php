<?php

declare(strict_types=1);

namespace Common\Annotation\Input\Validator;

use Attribute;
use Laminas\Validator\ValidatorInterface;
use Laminas\Validator;

#[Attribute]
class Date implements AttributeValidatorInterface
{
    public function __construct(private readonly string $format)
    {
    }

    public function getValidator(array $options = []): ValidatorInterface
    {
        return new Validator\Date(['format' => $this->format]);
    }
}
