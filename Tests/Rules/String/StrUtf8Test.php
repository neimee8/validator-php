<?php

namespace Neimee8\ValidatorPhp\Tests\Rules\String;

use Neimee8\ValidatorPhp\Tests\Rules\MustBeRuleTestCases;

/**
 * @group rules
 * @group string
 */
class StrUtf8Test extends MustBeRuleTestCases {
    protected static array $rules = ['str_utf8'];

    protected static function getCompatibleValue(): string {
        return 'some_string';
    }

    protected static function getValuesToPass(): array {
        return [
            'тест',
            '漢字',
            'áéí'
        ];
    }

    protected static function getValuesToFail(): array {
        return [
            "\xff",
            "abc\xff",
            "\xc3\x28"
        ];
    }
}
