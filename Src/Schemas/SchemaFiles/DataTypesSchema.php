<?php

declare(strict_types = 1);

return [

    'all' => [
        'mixed',
        'null',
        'int',
        '?int',
        'float',
        '?float',
        'string',
        '?string',
        'bool',
        '?bool',
        'array',
        '?array',
        'callable',
        '?callable',
        'object',
        '?object',
        'resource',
        '?resource',
        'iterable',
        '?iterable'
    ],

    'by_group' => [

        'general' => [
            'bool',
            '?bool',
            'null'
        ],

        'numeric' => [
            'int',
            '?int',
            'float',
            '?float'
        ],

        'string' => [
            'string',
            '?string'
        ],

        'array' => [
            'array',
            '?array'
        ],

        'callable' => [
            'callable',
            '?callable'
        ],

        'object' => [
            'object',
            '?object'
        ],

        'resource' => [
            'resource',
            '?resource'
        ],

        'iterable' => [
            'iterable',
            '?iterable'
        ]

    ]

];
