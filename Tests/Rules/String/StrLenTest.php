<?php

namespace Neimee8\ValidatorPhp\Tests\Rules\String;

use Neimee8\ValidatorPhp\Tests\Rules\RuleTestCases;
use Neimee8\ValidatorPhp\Tests\Rules\ParamTests\TestLenParamsTrait;

class StrLenTest extends RuleTestCases {
    use TestLenParamsTrait;

    protected static array $rules = ['str_len'];
    protected static mixed $compatible_value = 'some_string';

    private int $reference = 5;

    private array $values_to_pass = [
        '12345',
        'abcde',
        'qwert',
        '     ',
        '✅✅✅✅✅',
        'ūīķšž',
        "\n\n\n\n\n"
    ];

    private array $values_to_fail = [
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

    public function testStringPasses(): void {
        foreach ($this -> values_to_pass as $value) {
            $this -> assertRulePasses(
                rule: 'str_len',
                value: $value,
                params: $this -> reference
            );
        }
    }

    public function testStringFails(): void {
        foreach ($this -> values_to_fail as $value) {
            $this -> assertRuleFails(
                rule: 'str_len',
                value: $value,
                params: $this -> reference
            );
        }
    }
}
