<?php

declare(strict_types=1);

namespace Common\Annotation\Input\Validator;

use Attribute;
use Laminas\Validator\ValidatorInterface;
use Laminas\Validator;

#[Attribute]
class Digits implements AttributeValidatorInterface
{
    public function getValidator(array $options = []): ValidatorInterface
    {
        return new Validator\Digits();
    }
}
