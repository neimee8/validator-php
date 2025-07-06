<?php

namespace Neimee8\ValidatorPhp\Tests\Rules\General\ValueIn;

use Neimee8\ValidatorPhp\Tests\Rules\RuleTestCase;

class ValueInTest extends RuleTestCase {
    use TestCases;

    protected static array $rules = ['value_in'];
    protected static mixed $compatible_value = null;

    private string $pass_method = 'assertRulePasses';
    private string $fail_method = 'assertRuleFails';
}
