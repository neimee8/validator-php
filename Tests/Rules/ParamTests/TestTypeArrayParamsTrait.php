<?php

namespace Neimee8\ValidatorPhp\Tests\Rules\ParamTests;

trait TestTypeArrayParamsTrait {
    use BaseParamTestTrait;

    private static function getParamTestParamSet(): array {
        return [
            null,
            0,
            0.5,
            'some_string',
            true,
            fn () => true,
            new class {},
            ['some_string' => 'some_string'],
            [
                ['some_string', 'some_string'],
                ['some_string', 'some_string']
            ]
        ];
    }
}
