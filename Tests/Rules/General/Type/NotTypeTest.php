<?php

namespace Neimee8\ValidatorPhp\Tests\Rules\General\Type;

use Neimee8\ValidatorPhp\Tests\Rules\RuleTestCase;

class NotTypeTest extends RuleTestCase {
    use TestCases;

    private string $rule = 'not_type';

    private string $pass_method = 'assertRuleFails';
    private string $fail_method = 'assertRulePasses';
}
