<?php

declare(strict_types = 1);

return [
    'invert' => [
        'required' => false,
        'default' => false,
        'validation' => [
            [
                'rule' => 'type',
                'params' => [
                    'type' => 'bool'
                ]
            ]
        ]
    ]
];
