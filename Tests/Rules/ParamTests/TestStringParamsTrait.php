<?php

namespace Neimee8\ValidatorPhp\Tests\Rules\ParamTests;

trait TestStringParamsTrait {
    use BaseParamTestTrait;

    private static function getParamTestParamSet(): array {
        return [
            null,
            0,
            0.5,
            true,
            [1, 2, 3],
            fn () => true,
            new class {},
        ];
    }
}
