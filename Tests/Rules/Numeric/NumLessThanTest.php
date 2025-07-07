<?php

namespace Neimee8\ValidatorPhp\Tests\Rules\Numeric;

use Neimee8\ValidatorPhp\Tests\Rules\ReferenceRuleTestCases;
use Neimee8\ValidatorPhp\Tests\Rules\ParamTests\TestNumericParamsTrait;

/**
 * @group rules
 * @group numeric
 */
class NumLessThanTest extends ReferenceRuleTestCases {
    use TestNumericParamsTrait;

    protected static array $rules = ['num_less_than'];
    
    protected static function getCompatibleValue(): int {
        return 5;
    }

    protected array $references = [5, 5.0];

    protected static function getValuesToPass(): array {
        return [
            0, 1, 4.999999999999, -2, -2.15
        ];
    }

    protected static function getValuesToFail(): array {
        return [
            6, 7, 10000, 5.0000000001, 5, 5.0
        ];
    }
}
