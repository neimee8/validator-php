<?php

namespace Neimee8\ValidatorPhp\Tests\Rules\General\Type;

use Neimee8\ValidatorPhp\Tests\Rules\RuleTestCase;

class NotTypeTest extends RuleTestCase {
    use TestCases;

    protected static array $rules = ['not_type'];
    protected static mixed $compatible_value = null;

    private string $pass_method = 'assertRuleFails';
    private string $fail_method = 'assertRulePasses';
}
