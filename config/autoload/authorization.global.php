<?php

return [
    'mezzio-authorization-acl' => [
        'roles' => [
            'administrator' => [],
            'user' => [],
        ],
        'resources' => [
            'test.logging',
        ],
        'allow' => [
            'user' => [
                'test.logging',
            ],
            'administrator' => [
                'test.logging',
            ],
        ]
    ]
];
