<?php

namespace Neimee8\ValidatorPhp\Tests\Rules\General\ValueIn;

use Neimee8\ValidatorPhp\Tests\Rules\RuleTestCases;

class ValueInTest extends RuleTestCases {
    use TestCases;

    protected static array $rules = ['value_in'];

    private string $pass_method = 'assertRulePasses';
    private string $fail_method = 'assertRuleFails';
}
