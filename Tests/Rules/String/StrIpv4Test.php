<?php

namespace Neimee8\ValidatorPhp\Tests\Rules\String;

use Neimee8\ValidatorPhp\Tests\Rules\MustBeRuleTestCases;

/**
 * @group rules
 * @group string
 */
class StrIpv4Test extends MustBeRuleTestCases {
    protected static array $rules = ['str_ipv4'];
    
    protected static function getCompatibleValue(): string {
        return 'some_string';
    }

    protected static function getValuesToPass(): array {
        return [
            '127.0.0.1',
            '192.168.1.1',
            '10.0.0.254',
            '172.16.0.0',
        ];
    }

    protected static function getValuesToFail(): array {
        return [
            'some_incorrect_string',
            '1007.1.1.1',
            '2001:0db8:85a3:0000:0000:8a2e:0370:7334:9999',
            '2001:0db8:85a3:0000:000p:8a2e:0370:7334',
            '::1',
            '2001:0db8:85a3:0000:0000:8a2e:0370:7334',
            '2001:db8:85a3::8a2e:370:7334',
            'fe80::1ff:fe23:4567:890a',
            '::ffff:192.168.1.1',
            '2001:0:ce49:7601:e866:efff:62c3:fffe',
            '::'
        ];
    }
}
