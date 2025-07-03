<?php

namespace Neimee8\ValidatorPhp\Tests\Rules\General\Types;

use Neimee8\ValidatorPhp\Tests\RuleTestCase;

class NotTypesTest extends RuleTestCase {
    use TypesTestCases;

    private string $rule = 'not_types';

    private string $pass_method = 'assertRuleFails';
    private string $fail_method = 'assertRulePasses';
}
