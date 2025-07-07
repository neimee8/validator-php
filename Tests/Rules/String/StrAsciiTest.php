<?php

namespace Neimee8\ValidatorPhp\Tests\Rules\String;

use Neimee8\ValidatorPhp\Tests\Rules\MustBeRuleTestCases;

/**
 * @group rules
 * @group string
 */
class StrAsciiTest extends MustBeRuleTestCases {
    protected static array $rules = ['str_ascii'];

    protected static function getCompatibleValue(): string {
        return 'some_string';
    }

    protected static function getValuesToPass(): array {
        return [
            'abc123',
            '!@#$',
            'onlyASCII'
        ];
    }

    protected static function getValuesToFail(): array {
        return [
            'тест',
            '漢字',
            'áéí',
            '✅'
        ];
    }
}
