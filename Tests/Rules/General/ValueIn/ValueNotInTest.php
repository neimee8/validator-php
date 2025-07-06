<?php

namespace Neimee8\ValidatorPhp\Tests\Rules\General\ValueIn;

use Neimee8\ValidatorPhp\Tests\Rules\RuleTestCase;

class ValueNotInTest extends RuleTestCase {
    use TestCases;

    private string $rule = 'value_not_in';

    private string $pass_method = 'assertRuleFails';
    private string $fail_method = 'assertRulePasses';
}
