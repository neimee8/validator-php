<?php

namespace Neimee8\ValidatorPhp\Tests\Rules\String;

use Neimee8\ValidatorPhp\Tests\Rules\MustBeRuleTestCases;

/**
 * @group rules
 * @group string
 */
class StrFloatPositiveTest extends MustBeRuleTestCases {
    protected static array $rules = ['str_float_positive'];

    protected static function getCompatibleValue(): string {
        return 'some_string';
    }

    protected static function getValuesToPass(): array {
        return [
            '15.05',
            '20.01'
        ];
    }

    protected static function getValuesToFail(): array {
        return [
            'some_string',
            '1',
            '10000',
            '-15.05',
            '-1',
            '-10000',
            '0',
            '0.0'
        ];
    }
}
