<?php

namespace Neimee8\ValidatorPhp\Tests\Rules\String\StrRegexMatch;

use Neimee8\ValidatorPhp\Tests\Rules\RuleTestCases;

/**
 * @group rules
 * @group string
 */
class StrRegexMatchTest extends RuleTestCases {
    use TestCases;

    protected static array $rules = ['str_regex_match'];

    protected static function getCompatibleValue(): string {
        return 'some_string';
    }

    private string $pass_method = 'assertRulePasses';
    private string $fail_method = 'assertRuleFails';
}
