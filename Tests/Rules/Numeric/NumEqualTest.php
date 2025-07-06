<?php

namespace Neimee8\ValidatorPhp\Tests\Rules\Numeric;

use Neimee8\ValidatorPhp\Tests\Rules\RuleTestCase;
use Neimee8\ValidatorPhp\Tests\Rules\ParamTests\TestNumericParamsTrait;

class NumEqualTest extends RuleTestCase {
    use TestNumericParamsTrait;
    
    protected static array $rules = [
        'num_more_or_equal',
        'num_less_or_equal'
    ];

    protected static mixed $compatible_value = 5;

    public function testEqual(): void {
        $param_set = [
            [
                'value' => 5,
                'reference' => 5
            ],
            [
                'value' => 5.0,
                'reference' => 5.0
            ],
            [
                'value' => 5,
                'reference' => 5.0
            ],
            [
                'value' => 5.0,
                'reference' => 5
            ]
        ];

        foreach ($param_set as $params) {
            foreach (self::$rules as $rule) {
                $this -> assertRulePasses(
                    rule: $rule,
                    value: $params['value'],
                    params: $params['reference']
                );
            }
        }
    }
}
