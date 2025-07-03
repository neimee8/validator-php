<?php

namespace Neimee8\ValidatorPhp\Tests\Rules\General\Type;

use Neimee8\ValidatorPhp\Tests\RuleTestCase;

class TypeTest extends RuleTestCase {
    use TypeTestCases;

    private string $rule = 'type';

    private string $pass_method = 'assertRulePasses';
    private string $fail_method = 'assertRuleFails';
}
