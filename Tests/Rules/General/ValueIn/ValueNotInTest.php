<?php

namespace Neimee8\ValidatorPhp\Tests\Rules\General\ValueIn;

use Neimee8\ValidatorPhp\Tests\Rules\RuleTestCases;

/**
 * @group rules
 * @group general
 */
class ValueNotInTest extends RuleTestCases {
    use TestCases;

    protected static array $rules = ['value_not_in'];

    private string $pass_method = 'assertRuleFails';
    private string $fail_method = 'assertRulePasses';
}
