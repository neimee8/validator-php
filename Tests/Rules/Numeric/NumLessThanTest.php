<?php

namespace Neimee8\ValidatorPhp\Tests\Rules\Numeric;

use Neimee8\ValidatorPhp\Tests\Rules\RuleTestCase;
use Neimee8\ValidatorPhp\Tests\Rules\ParamTests\TestNumericParamsTrait;

class NumLessThanTest extends RuleTestCase {
    use TestNumericParamsTrait;

    protected static array $rules = ['num_less_than'];
    protected static mixed $compatible_value = 5;

    private array $references = [5, 5.0];

    private array $values_to_pass = [
        0, 1, 4.999999999999, -2, -2.15
    ];

    private array $values_to_fail = [
        6, 7, 10000, 5.0000000001, 5, 5.0
    ];

    public function testNumPasses(): void {
        foreach ($this -> values_to_pass as $value) {
            foreach ($this -> references as $reference) {
                $this -> assertRulePasses(
                    rule: 'num_less_than',
                    value: $value,
                    params: $reference
                );
            }
        }
    }

    public function testNumFails(): void {
        foreach ($this -> values_to_fail as $value) {
            foreach ($this -> references as $reference) {
                $this -> assertRuleFails(
                    rule: 'num_less_than',
                    value: $value,
                    params: $reference
                );
            }
        }
    }
}
