<?php

namespace Neimee8\ValidatorPhp\Tests\Rules\String;

use Neimee8\ValidatorPhp\Tests\Rules\MustBeRuleTestCases;

/**
 * @group rules
 * @group string
 */
class StrNumericPositiveTest extends MustBeRuleTestCases {
    protected static array $rules = ['str_numeric_positive'];

    protected static function getCompatibleValue(): string {
        return 'some_string';
    }

    protected static function getValuesToPass(): array {
        return [
            '1',
            '10000',
            '15.05'
        ];
    }

    protected static function getValuesToFail(): array {
        return [
            'some_string',
            '-15.05',
            '-1',
            '-10000',
            '0',
            '0.0'
        ];
    }
}
