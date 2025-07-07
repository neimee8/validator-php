<?php

namespace Neimee8\ValidatorPhp\Tests\Rules\String;

use Neimee8\ValidatorPhp\Tests\Rules\ReferenceRuleTestCases;
use Neimee8\ValidatorPhp\Tests\Rules\ParamTests\TestLenParamsTrait;

class StrMaxLenTest extends ReferenceRuleTestCases {
    use TestLenParamsTrait;

    protected static array $rules = ['str_max_len'];

    protected static function getCompatibleValue(): string {
        return 'some_string';
    }

    protected array $references = [5];

    protected static function getValuesToPass(): array {
        return [
            '12345',
            'abcde',
            'qwert',
            '     ',
            '✅✅✅✅✅',
            'ūīķšž',
            "\n\n\n\n\n",
            '1',
            '123',
            '✅✅✅✅',
            '    ',
            "\n\n\t"
        ];
    }

    protected static function getValuesToFail(): array {
        return [
            '12345666',
            'abcdef',
            'qwertqq',
            '       ',
            '✅✅✅✅✅‼️‼️‼️‼️‼️‼️‼️',
            'ūīķšžasas',
            "\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n"
        ];
    }
}
