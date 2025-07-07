<?php

namespace Neimee8\ValidatorPhp\Tests\Rules\String;

use Neimee8\ValidatorPhp\Tests\Rules\MustBeRuleTestCases;

/**
 * @group rules
 * @group string
 */
class StrFloatTest extends MustBeRuleTestCases {
    protected static array $rules = ['str_float'];

    protected static function getCompatibleValue(): string {
        return 'some_string';
    }

    protected static function getValuesToPass(): array {
        return [
            '15.05',
            '1.0',
            '-2.000004',
            '0.0'
        ];
    }

    protected static function getValuesToFail(): array {
        return [
            'some_string',
            '1',
            '-1',
            '10000',
            '-10000',
            '0'
        ];
    }
}
