<?php

namespace Neimee8\ValidatorPhp\Tests\Rules\String;

use Neimee8\ValidatorPhp\Tests\Rules\MustBeRuleTestCases;

/**
 * @group rules
 * @group string
 */
class StrContainsSpecialTest extends MustBeRuleTestCases {
    protected static array $rules = ['str_contains_special'];
    
    protected static function getCompatibleValue(): string {
        return 'some_string';
    }

    protected static function getValuesToPass(): array {
        return [
            'helloworld!',
            '&',
            '✅',
            ',',
            ' ',
            "\t",
            "\n",
            '?',
            '%',
            '-',
            '+',
            '=',
            '~',
            '@'
        ];
    }

    protected static function getValuesToFail(): array {
        return [
            'abcde',
            '123',
            'ūīķļ'
        ];
    }
}
