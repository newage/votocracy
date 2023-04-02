<?php

declare(strict_types=1);

namespace App\InputFilter;

use App\Entity\Enum\Status;
use Common\Validator\EnumValidator;
use Laminas\InputFilter\InputFilter;
use Laminas\Validator;
use Common\Filter\EnumFilter;

class ApplicationFilter extends InputFilter
{
    public function init()
    {
        $this->add([
            'name' => 'message',
            'allow_empty' => false,
            'validators' => [
                [
                    'name' => Validator\StringLength::class,
                    'options' => ['min' => 5, 'max' => 255]
                ],
            ],
        ]);
        $this->add([
            'name' => 'status',
            'allow_empty' => false,
            'validators' => [
                [
                    'name' => EnumValidator::class,
                    'options' => ['enumType' => Status::class]
                ],
            ],
            'filters' => [
                [
                    'name' => EnumFilter::class,
                    'options' => ['enumType' => Status::class]
                ],
            ]
        ]);
    }
}
