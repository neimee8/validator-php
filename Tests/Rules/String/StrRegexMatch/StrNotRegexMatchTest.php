<?php

namespace Neimee8\ValidatorPhp\Tests\Rules\String\StrRegexMatch;

use Neimee8\ValidatorPhp\Tests\Rules\RuleTestCases;

/**
 * @group rules
 * @group string
 */
class StrNotRegexMatchTest extends RuleTestCases {
    use TestCases;

    protected static array $rules = ['str_not_regex_match'];

    protected static function getCompatibleValue(): string {
        return 'some_string';
    }

    private string $pass_method = 'assertRuleFails';
    private string $fail_method = 'assertRulePasses';
}
