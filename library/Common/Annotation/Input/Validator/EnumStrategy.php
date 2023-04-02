<?php

declare(strict_types=1);

namespace Common\Annotation\Input\Validator;

use Attribute;
use Common\Validator\EnumValidator;
use Laminas\Validator\ValidatorInterface;

#[Attribute]
final class EnumStrategy implements AttributeValidatorInterface
{
    public function __construct(private readonly string $class)
    {
    }

    public function getValidator(array $options = []): ValidatorInterface
    {
        return new EnumValidator(['enumType' => $this->class]);
    }
}
