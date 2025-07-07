<?php

namespace Neimee8\ValidatorPhp\Tests\Rules\String;

use Neimee8\ValidatorPhp\Tests\Rules\MustBeRuleTestCases;

/**
 * @group rules
 * @group string
 */
class StrContainsHtmlTest extends MustBeRuleTestCases {
    protected static array $rules = ['str_contains_html'];

    protected static function getCompatibleValue(): string {
        return 'some_string';
    }

    protected static function getValuesToPass(): array {
        return [
            '<b>bold</b>',
            '<div>Text</div>',
            '<a href="#">link</a>'
        ];
    }

    protected static function getValuesToFail(): array {
        return [
            'no html here',
            'plain text',
            '123'
        ];
    }
}
