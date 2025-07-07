<?php

namespace Neimee8\ValidatorPhp\Tests\Rules\String;

use Neimee8\ValidatorPhp\Tests\Rules\MustBeRuleTestCases;

/**
 * @group rules
 * @group string
 */
class StrBase64Test extends MustBeRuleTestCases {
    protected static array $rules = ['str_base64'];

    protected static function getCompatibleValue(): string {
        return 'some_string';
    }

    protected static function getValuesToPass(): array {
        return [
            'U29tZVN0cmluZw==',
            'YWJjZGVmZ2g='
        ];
    }

    protected static function getValuesToFail(): array {
        return [
            'not_base64',
            '12345',
            '<tag>'
        ];
    }
}
