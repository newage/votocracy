<?php

declare(strict_types=1);

namespace Common\Annotation\Input\Validator;

use Attribute;
use Common\Validator\NestedValidator;
use Laminas\Validator\ValidatorInterface;

#[Attribute]
final class NestedEntity implements AttributeValidatorInterface
{
    public function __construct(private readonly string $class, private readonly array $validationGroup)
    {
    }

    public function getValidator(array $options = []): ValidatorInterface
    {
        return new NestedValidator(['validationGroup' => $this->validationGroup]);
    }

    public function getNestedClass(): string
    {
        return $this->class;
    }
}
