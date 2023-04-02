<?php

declare(strict_types=1);

namespace Common\Validator;

use Laminas\InputFilter\InputFilterInterface;
use Laminas\Validator\AbstractValidator;

class NestedValidator extends AbstractValidator
{
    protected const NESTED = 'nested_entity';

    protected $messageTemplates = [
        self::NESTED => 'Nested entity %value%',
    ];

    protected $options = [
        'validationGroup' => null
    ];

    protected InputFilterInterface $inputFilter;

    public function __construct(array $options = [])
    {
        $this->options = $options;
        parent::__construct($options);
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        $this->inputFilter = $inputFilter;
    }

    public function isValid($value): bool
    {
        $this->inputFilter->setValidationGroup($this->options['validationGroup']);
        $this->inputFilter->setData($value);
        $validateResult = $this->inputFilter->isValid();
        if (!$validateResult) {
            $this->error(self::NESTED, $this->inputFilter->getMessages());
        }
        return $validateResult;
    }
}
