<?php

namespace Common\Annotation\Input\Validator;

use Common\Annotation\AttributeInputFilterInterface;
use Laminas\Validator\ValidatorInterface;

interface AttributeValidatorInterface extends AttributeInputFilterInterface
{
    public function getValidator(array $options = []): ValidatorInterface;
}
