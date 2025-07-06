<?php

namespace Neimee8\ValidatorPhp\Tests\Rules\Numeric;

use Neimee8\ValidatorPhp\Tests\Rules\RuleTestCases;
use Neimee8\ValidatorPhp\Tests\Rules\ParamTests\TestBoolParamsTrait;

class NumZeroTest extends RuleTestCases {
    use TestBoolParamsTrait;
    
    protected static array $rules = [
        'num_positive_zero',
        'num_negative_zero'
    ];
    
    protected static mixed $compatible_value = 5;

    public function testZero(): void {
        $param_set = [true, false];
        $methods = [
            (string) true => 'assertRulePasses',
            (string) false => 'assertRuleFails'
        ];

        foreach ($param_set as $params) {
            foreach (self::$rules as $rule) {
                $this -> {$methods[(string) $params]} (
                    rule: $rule,
                    value: 0,
                    params: $params
                );
            }
        }
    }
}
