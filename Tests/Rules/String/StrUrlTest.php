<?php

namespace Neimee8\ValidatorPhp\Tests\Rules\String;

use Neimee8\ValidatorPhp\Tests\Rules\MustBeRuleTestCases;

/**
 * @group rules
 * @group string
 */
class StrUrlTest extends MustBeRuleTestCases {
    protected static array $rules = ['str_url'];
    
    protected static function getCompatibleValue(): string {
        return 'some_string';
    }

    protected static function getValuesToPass(): array {
        return [
            'http://google.com/',
            'https://google.com/',
            'https://google.com',
            'https://www.google.com',
            'https://google.com/page?id=1&parameter=value',
        ];
    }

    protected static function getValuesToFail(): array {
        return [
            'some_string',
            '123456',
            'www.google@com'
        ];
    }
}
