<?php

declare(strict_types=1);

namespace Common\Annotation\Input\Validator;

use Attribute;
use Laminas\Validator\ValidatorInterface;

#[Attribute]
class IsFloat implements AttributeValidatorInterface
{
    public function getValidator(array $options = []): ValidatorInterface
    {
        return new \Laminas\I18n\Validator\IsFloat();
    }
}
