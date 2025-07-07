<?php

namespace Neimee8\ValidatorPhp\Tests\Rules\String;

use Neimee8\ValidatorPhp\Tests\Rules\MustBeRuleTestCases;

/**
 * @group rules
 * @group string
 */
class StrUppercaseTest extends MustBeRuleTestCases {
    protected static array $rules = ['str_uppercase'];

    protected static function getCompatibleValue(): string {
        return 'some_string';
    }

    protected static function getValuesToPass(): array {
        return [
            'UPPERCASE',
            'ABC',
            'TEST',
            'UPPERCASE TEXT',
            "\n\n\n\n",
            '     '
        ];
    }

    protected static function getValuesToFail(): array {
        return [
            'lower',
            'CamelCase',
            '123lower'
        ];
    }
}
