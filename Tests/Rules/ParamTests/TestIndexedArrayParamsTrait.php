<?php

namespace Neimee8\ValidatorPhp\Tests\Rules\ParamTests;

trait TestIndexedArrayParamsTrait {
    use BaseParamTestTrait;

    private static function getParamTestParamSet(): array {
        return [
            5,
            5.5,
            'some_string',
            new class {},
            fn() => true,
            ['assoc' => 'array']
        ];
    }
}
