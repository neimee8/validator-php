<?php

namespace Neimee8\ValidatorPhp\Tests\Rules\General\Types;

use Neimee8\ValidatorPhp\Tests\Rules\RuleTestCase;

class TypesTest extends RuleTestCase {
    use TestCases;

    protected static array $rules = ['types'];
    protected static mixed $compatible_value = null;

    private string $pass_method = 'assertRulePasses';
    private string $fail_method = 'assertRuleFails';
}
