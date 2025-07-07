<?php

namespace Neimee8\ValidatorPhp\Tests\Rules\String;

use Neimee8\ValidatorPhp\Tests\Rules\MustBeRuleTestCases;

/**
 * @group rules
 * @group string
 */
class StrIsClassStringTest extends MustBeRuleTestCases {
    protected static array $rules = ['str_is_class_string'];

    protected static function getCompatibleValue(): string {
        return 'some_string';
    }

    protected static function getValuesToPass(): array {
        return [
            'DateTime',
            '\\Exception',
            'Neimee8\\ValidatorPhp\\Validator'
        ];
    }

    protected static function getValuesToFail(): array {
        return [
            'notaclass',
            '123',
            'wrong\path'
        ];
    }
}
