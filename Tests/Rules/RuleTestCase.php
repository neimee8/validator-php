<?php

namespace Neimee8\ValidatorPhp\Tests\Rules;

use \PHPUnit\Framework\TestCase;

use Neimee8\ValidatorPhp\Validator;
use Neimee8\ValidatorPhp\Exceptions\ValidationException;

abstract class RuleTestCase extends TestCase {
    protected static array $rules = [];
    protected static mixed $compatible_value = null;

    protected function assertRulePasses(
        mixed $rule,
        mixed $value,
        mixed $params = [],
        ?string $message = null
    ): void {
        $result = Validator::$rule($value, $params);
        $this -> assertTrue(
            $result,
            $message
            ?? 'Expected rule '
            . var_export($rule, true)
            . ' to pass for value: '
            . var_export($value, true)
            . ', params: '
            . var_export($params, true)
        );
    }

    protected function assertRuleFails(
        mixed $rule,
        mixed $value,
        mixed $params = [],
        ?string $message = null
    ): void {
        $result = Validator::$rule($value, $params);
        $this -> assertFalse(
            $result,
            $message
            ?? 'Expected rule '
            . var_export($rule, true)
            . ' to fail for value: '
            . var_export($value, true)
            . ', params: '
            . var_export($params, true)
        );
    }

    protected function assertRuleThrows(
        mixed $rule,
        mixed $value,
        mixed $params = [],
        string $expected_exception = ValidationException::class,
        ?string $message = null
    ): void {
        $this -> expectException($expected_exception);
        Validator::$rule($value, $params);

        $this -> fail(
            $message
            ?? 'Expected rule '
            . var_export($rule, true)
            . ' to throw '
            . $expected_exception
            . ' for value: '
            . var_export($value, true)
            . ', params: '
            . var_export($params, true)
        );
    }

    protected static function getRules(): array {
        return static::$rules;
    }

    protected static function getCompatibleValue(): mixed {
        return static::$compatible_value;
    }
}
