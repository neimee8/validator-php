<?php

namespace Neimee8\ValidatorPhp\Tests\Rules\String;

use Neimee8\ValidatorPhp\Tests\Rules\MustBeRuleTestCases;

/**
 * @group rules
 * @group string
 */
class StrIsRegexTest extends MustBeRuleTestCases {
    protected static array $rules = ['str_is_regex'];

    protected static function getCompatibleValue(): string {
        return 'some_string';
    }

    protected static function getValuesToPass(): array {
        return [
            '/[a-z]+/',
            '/^test$/',
            '/\d{2,4}/i'
        ];
    }

    protected static function getValuesToFail(): array {
        return [
            'not a regex',
            'abc',
            '[unterminated'
        ];
    }
}
