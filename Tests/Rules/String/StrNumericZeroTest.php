<?php

namespace Neimee8\ValidatorPhp\Tests\Rules\String;

use Neimee8\ValidatorPhp\Tests\Rules\MustBeRuleTestCases;

/**
 * @group rules
 * @group string
 */
class StrNumericZeroTest extends MustBeRuleTestCases {
    protected static array $rules = [
        'str_numeric_negative_zero',
        'str_numeric_positive_zero'
    ];

    protected static function getCompatibleValue(): string {
        return 'some_string';
    }

    protected static function getValuesToPass(): array {
        return ['0', '0.0'];
    }

    protected static function getValuesToFail(): array {
        return [];
    }
}
