<?php

namespace Neimee8\ValidatorPhp\Tests\Rules\String;

use Neimee8\ValidatorPhp\Tests\Rules\MustBeRuleTestCases;

/**
 * @group rules
 * @group string
 */
class StrLowercaseTest extends MustBeRuleTestCases {
    protected static array $rules = ['str_lowercase'];

    protected static function getCompatibleValue(): string {
        return 'some_string';
    }

    protected static function getValuesToPass(): array {
        return [
            'lowercase',
            'abc',
            'teststring',
            'some test',
            '',
            ' ',
            "\n\n\n"
        ];
    }

    protected static function getValuesToFail(): array {
        return [
            'UPPER',
            'CamelCase',
            'With123'
        ];
    }
}
