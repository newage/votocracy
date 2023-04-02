<?php

declare(strict_types=1);

namespace Common\Annotation\Input\Validator\Db;

use Attribute;
use Common\Annotation\Input\Validator\AttributeValidatorInterface;
use Common\Exception\CriticalException;
use Laminas\Validator\ValidatorInterface;
use Laminas\Validator;

#[Attribute]
final class RecordExists implements AttributeValidatorInterface
{
    public function __construct(private readonly string $table, private readonly string $field)
    {
    }

    public function getValidator(array $options = []): ValidatorInterface
    {
        $options['table'] = $this->table;
        $options['field'] = $this->field;
        return new Validator\Db\RecordExists($options);
    }
}
