<?php

namespace Neimee8\ValidatorPhp\Tests\Rules\Numeric;

use Neimee8\ValidatorPhp\Tests\Rules\RuleTestCases;
use Neimee8\ValidatorPhp\Tests\Rules\ParamTests\TestBoolParamsTrait;

class NumPositiveTest extends RuleTestCases {
    use TestBoolParamsTrait;

    protected static array $rules = ['num_positive'];
    protected static mixed $compatible_value = 5;

    private array $values_to_pass = [
        1, 2, 3, 1000, 0.5, 0.1,
        0.000000000000000001, 100.25937827
    ];

    private array $values_to_fail = [
        0, -1, -2, -3, -1000, -0.5, -0.1,
        -0.000000000000000001, -100.25937827
    ];

    public function testNumPasses(): void {
        foreach ($this -> values_to_pass as $num) {
            $this -> assertRulePasses(
                rule: 'num_positive',
                value: $num,
                params: true
            );

            $this -> assertRuleFails(
                rule: 'num_positive',
                value: $num,
                params: false
            );
        }
    }

    public function testNumFails(): void {
        foreach ($this -> values_to_fail as $num) {
            $this -> assertRuleFails(
                rule: 'num_positive',
                value: $num,
                params: true
            );

            $this -> assertRulePasses(
                rule: 'num_positive',
                value: $num,
                params: false
            );
        }
    }
}
