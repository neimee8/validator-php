<?php

namespace Neimee8\ValidatorPhp\Tests\Rules\General\ValueIn;

use Neimee8\ValidatorPhp\Tests\Rules\RuleTestCase;

class ValueInTest extends RuleTestCase {
    use TestCases;

    private string $rule = 'value_in';

    private string $pass_method = 'assertRulePasses';
    private string $fail_method = 'assertRuleFails';
}
