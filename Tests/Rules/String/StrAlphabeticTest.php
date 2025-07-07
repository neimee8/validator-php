<?php

namespace Neimee8\ValidatorPhp\Tests\Rules\String;

use Neimee8\ValidatorPhp\Tests\Rules\MustBeRuleTestCases;

/**
 * @group rules
 * @group string
 */
class StrAlphabeticTest extends MustBeRuleTestCases {
    protected static array $rules = ['str_alphabetic'];
    
    protected static function getCompatibleValue(): string {
        return 'some_string';
    }

    protected static function getValuesToPass(): array {
        return [
            'helloworld',
            'abcde',
            'ūīčķļ'
        ];
    }

    protected static function getValuesToFail(): array {
        return [
            'abc1',
            'hello world!',
            'hello world',
            "    \n",
            "hello\t\tworld",
            '‼️hhh'
        ];
    }
}
