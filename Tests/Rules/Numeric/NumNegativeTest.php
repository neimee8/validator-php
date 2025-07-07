<?php

namespace Neimee8\ValidatorPhp\Tests\Rules\Numeric;

use Neimee8\ValidatorPhp\Tests\Rules\MustBeRuleTestCases;

/**
 * @group rules
 * @group numeric
 */
class NumNegativeTest extends MustBeRuleTestCases {
    protected static array $rules = ['num_negative'];
    
    protected static function getCompatibleValue(): int {
        return 5;
    }

    protected static function getValuesToPass(): array {
        return [
            -1, -2, -3, -1000, -0.5, -0.1,
            -0.000000000000000001, -100.25937827
        ];
    }

    protected static function getValuesToFail(): array {
        return [
            0, 1, 2, 3, 1000, 0.5, 0.1,
            0.000000000000000001, 100.25937827
        ];
    }
}
