<?php

namespace Neimee8\ValidatorPhp\Tests\Rules\General\Types;

use Neimee8\ValidatorPhp\Tests\RuleTestCase;

class TypesTest extends RuleTestCase {
    use TypesTestCases;

    private string $rule = 'types';

    private string $pass_method = 'assertRulePasses';
    private string $fail_method = 'assertRuleFails';
}
