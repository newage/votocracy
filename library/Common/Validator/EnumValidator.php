<?php

declare(strict_types=1);

namespace Common\Validator;

use Laminas\Validator\AbstractValidator;

class EnumValidator extends AbstractValidator
{
    protected const HAYSTACK = 'haystack';

    protected $messageTemplates = [
        self::HAYSTACK => "The input was not found in the haystack",
    ];

    protected $options = [
        'enumType' => null
    ];

    public function __construct(array $options = [])
    {
        $this->options = $options;
        parent::__construct($options);
    }

    public function isValid($value): bool
    {
        $this->setValue($value);

        if ($value instanceof $this->options['enumType']) {
            return true;
        }

        if (!$this->options['enumType']::tryFrom($value)) {
            $this->error(self::HAYSTACK);
            return false;
        }

        return true;
    }
}
