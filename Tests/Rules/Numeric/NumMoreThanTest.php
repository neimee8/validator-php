<?php

namespace Neimee8\ValidatorPhp\Tests\Rules\Numeric;

use Neimee8\ValidatorPhp\Tests\Rules\ReferenceRuleTestCases;
use Neimee8\ValidatorPhp\Tests\Rules\ParamTests\TestNumericParamsTrait;

class NumMoreThanTest extends ReferenceRuleTestCases {
    use TestNumericParamsTrait;

    protected static array $rules = ['num_more_than'];
    
    protected static function getCompatibleValue(): int {
        return 5;
    }

    protected array $references = [5, 5.0];

    protected static function getValuesToPass(): array {
        return [
            6, 7, 10000, 5.000000000001
        ];
    }

    protected static function getValuesToFail(): array {
        return [
            0, 1, 4.999999999999, -2, -2.15, 5, 5.0
        ];
    }
}
