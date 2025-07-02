<?php

namespace Neimee8\ValidatorPhp\Tests;

use \PHPUnit\Framework\TestCase;

use Neimee8\ValidatorPhp\Validator;
use Neimee8\ValidatorPhp\Exceptions\ValidationException;

abstract class RuleTestCase extends TestCase
{
    protected function assertRulePasses(
        mixed $rule,
        mixed $value,
        mixed $params = [],
        ?string $message = null
    ): void {
        $result = Validator::$rule($value, $params);
        $this -> assertTrue($result, $message ?? 'Expected rule ' . var_export($rule, true) . ' to pass for value: ' . var_export($value, true));
    }

    protected function assertRuleFails(
        mixed $rule,
        mixed $value,
        mixed $params = [],
        ?string $message = null
    ): void {
        $result = Validator::$rule($value, $params);
        $this -> assertFalse($result, $message ?? 'Expected rule ' . var_export($rule, true) . ' to fail for value: ' . var_export($value, true));
    }

    protected function assertRuleThrows(
        mixed $rule,
        mixed $value,
        mixed $params = [],
        string $expectedException = ValidationException::class,
        ?string $message = null
    ): void {
        $this -> expectException($expectedException);
        Validator::$rule($value, $params);

        $this -> fail($message ?? 'Expected rule ' . var_export($rule, true) . ' to throw $expectedException');
    }
}
