<?php

declare(strict_types=1);

namespace Common\Annotation;

use Attribute;

#[Attribute]
final class InputFilter implements AttributeInputFilterInterface
{
    public function __construct(
        private readonly bool $required,
        private readonly bool $allowEmpty = false,
        private readonly bool $breakOnFailure = true,
    ) {
    }

    public function isRequired(): bool
    {
        return $this->required;
    }

    public function isAllowEmpty(): bool
    {
        return $this->allowEmpty;
    }

    public function isBreakOnFailure(): bool
    {
        return $this->breakOnFailure;
    }
}
