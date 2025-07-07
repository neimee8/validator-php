<?php

namespace Neimee8\ValidatorPhp\Tests\Rules\Numeric;

use Neimee8\ValidatorPhp\Tests\Rules\ReferenceRuleTestCases;
use Neimee8\ValidatorPhp\Tests\Rules\ParamTests\TestNumericParamsTrait;

class NumEqualTest extends ReferenceRuleTestCases {
    use TestNumericParamsTrait;
    
    protected static array $rules = [
        'num_more_or_equal',
        'num_less_or_equal'
    ];

    protected static function getCompatibleValue(): int {
        return 5;
    }

    protected array $references = [5, 5.0];

    protected static function getValuesToPass(): array {
        return [5, 5.0];
    }

    protected static function getValuesToFail(): array {
        return [];
    }
}
