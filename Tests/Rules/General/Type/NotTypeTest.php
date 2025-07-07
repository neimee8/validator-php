<?php

namespace Neimee8\ValidatorPhp\Tests\Rules\General\Type;

use Neimee8\ValidatorPhp\Tests\Rules\RuleTestCases;

class NotTypeTest extends RuleTestCases {
    use TestCases;

    protected static array $rules = ['not_type'];

    private string $pass_method = 'assertRuleFails';
    private string $fail_method = 'assertRulePasses';
}
