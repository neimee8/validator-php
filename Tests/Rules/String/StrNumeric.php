<?php

namespace Neimee8\ValidatorPhp\Tests\Rules\String;

use Neimee8\ValidatorPhp\Tests\Rules\MustBeRuleTestCases;

class StrNumericTest extends MustBeRuleTestCases {
    protected static array $rules = ['str_numeric'];
    
    protected static function getCompatibleValue(): string {
        return 'some_string';
    }

    protected static function getValuesToPass(): array {
        return [
            '1',
            '0',
            '-1',
            '10.15',
            '-15.2',
            '1.00000000002',
            '-2.000000003',
            '+5',
            ' 12.56',
            '12.56 ',
            '     12.56   ',
            "  \t\t\t\n\n\n\t12.56\t\t\n\n\n    ",
            '.34',
            '5e10',
            '36E-8'
        ];
    }

    protected static function getValuesToFail(): array {
        return [
            '123abc',
            '105,66',
            '1 55',
            "1\n\n\n\t222   333\t\t\t"
        ];
    }
}
