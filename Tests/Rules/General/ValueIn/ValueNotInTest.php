<?php

namespace Neimee8\ValidatorPhp\Tests\Rules\General\ValueIn;

use Neimee8\ValidatorPhp\Tests\Rules\RuleTestCase;

class ValueNotInTest extends RuleTestCase {
    use TestCases;

    protected static array $rules = ['value_not_in'];
    protected static mixed $compatible_value = null;

    private string $pass_method = 'assertRuleFails';
    private string $fail_method = 'assertRulePasses';
}
