<?php

namespace Neimee8\ValidatorPhp\Tests\Rules\General\Types;

use Neimee8\ValidatorPhp\Tests\Rules\RuleTestCases;

class NotTypesTest extends RuleTestCases {
    use TestCases;

    protected static array $rules = ['not_types'];
    protected static mixed $compatible_value = null;

    private string $pass_method = 'assertRuleFails';
    private string $fail_method = 'assertRulePasses';
}
