<?php

namespace Neimee8\ValidatorPhp\Tests\Rules\Numeric;

use Neimee8\ValidatorPhp\Tests\Rules\MustBeRuleTestCases;

class NumZeroTest extends MustBeRuleTestCases {
    protected static array $rules = [
        'num_positive_zero',
        'num_negative_zero'
    ];
    
    protected static function getCompatibleValue(): int {
        return 5;
    }

    protected static function getValuesToPass(): array {
        return [0];
    }

    protected static function getValuesToFail(): array {
        return [];
    }
}
