<?php

namespace Neimee8\ValidatorPhp\Tests\Rules\String;

use Neimee8\ValidatorPhp\Tests\Rules\ReferenceRuleTestCases;
use Neimee8\ValidatorPhp\Tests\Rules\ParamTests\TestLenParamsTrait;

/**
 * @group rules
 * @group string
 */
class StrLenTest extends ReferenceRuleTestCases {
    use TestLenParamsTrait;

    protected static array $rules = ['str_len'];

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
            "\n\n\n\n\n"
        ];
    }

    protected static function getValuesToFail(): array {
        return [
            '1',
            'some_string',
            '✅✅✅✅',
            '✅✅✅✅✅✅',
            '123456',
            'Lorem ipsum dolor sit amet consectetur adipisicing elit. '
            . 'Id perspiciatis suscipit, ullam sed earum illo cumque accusantium '
            . 'expedita nisi maiores, impedit harum est eveniet a tempore! Quasi '
            . 'placeat doloribus ad?'
        ];
    }
}
