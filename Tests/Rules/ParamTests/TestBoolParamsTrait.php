<?php

namespace Neimee8\ValidatorPhp\Tests\Rules\ParamTests;

trait TestBoolParamsTrait {
    use BaseParamTestTrait;

    private static function getParamTestParamSet(): array {
        return [
            0,
            0.5,
            'some_string',
            fn() => true,
            null,
            new class {},
            [1, 2, 3]
        ];
    }
}
