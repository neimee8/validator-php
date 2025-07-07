<?php

namespace Neimee8\ValidatorPhp\Tests\Rules\General\Type;

use Neimee8\ValidatorPhp\Tests\Rules\RuleTestCases;

class TypeTest extends RuleTestCases {
    use TestCases;

    protected static array $rules = ['type'];

    private string $pass_method = 'assertRulePasses';
    private string $fail_method = 'assertRuleFails';
}
