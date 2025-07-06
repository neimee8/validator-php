<?php

namespace Neimee8\ValidatorPhp\Tests\Rules\ParamTests;

trait TestNumericParamsTrait {
    use BaseParamTestTrait;

    private static function getParamTestParamSet(): array {
        return [
            'some_string',
            fn() => true,
            true,
            false,
            null,
            new class {},
            [1, 2, 3]
        ];
    }
}
