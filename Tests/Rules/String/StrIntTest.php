<?php

namespace Neimee8\ValidatorPhp\Tests\Rules\String;

use Neimee8\ValidatorPhp\Tests\Rules\MustBeRuleTestCases;

/**
 * @group rules
 * @group string
 */
class StrIntTest extends MustBeRuleTestCases {
    protected static array $rules = ['str_int'];

    protected static function getCompatibleValue(): string {
        return 'some_string';
    }

    protected static function getValuesToPass(): array {
        return [
            '1',
            '-1',
            '10000',
            '-10000',
            '0'
        ];
    }

    protected static function getValuesToFail(): array {
        return [
            'some_string',
            '15.05',
            '-15.05'
        ];
    }
}
