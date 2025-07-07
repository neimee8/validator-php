<?php

namespace Neimee8\ValidatorPhp\Tests\Rules\String;

use Neimee8\ValidatorPhp\Tests\Rules\MustBeRuleTestCases;

/**
 * @group rules
 * @group string
 */
class StrJsonTest extends MustBeRuleTestCases {
    protected static array $rules = ['str_json'];
    
    protected static function getCompatibleValue(): string {
        return 'some_string';
    }

    protected static function getValuesToPass(): array {
        return [
            json_encode(null),
            json_encode([1, 2, 3]),
            json_encode(['a' => 'b']),
            json_encode('some_string')
        ];
    }

    protected static function getValuesToFail(): array {
        return [
            'abcde',
            '[\'key\': \'value\']',
            '{\'key1\': \'value1\', \'key2\': \'value2\',}',
            '{\'key1\': \'value1\' \'key2\': \'value2\'}'
        ];
    }
}
