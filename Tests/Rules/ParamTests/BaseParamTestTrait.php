<?php

namespace Neimee8\ValidatorPhp\Tests\Rules\ParamTests;

use Neimee8\ValidatorPhp\Exceptions\ValidationParamsException;

trait BaseParamTestTrait {
    public static function provideIncompatibleParams(): array {
        $cases = [];

        foreach (static::getParamTestParamSet() as $params) {
            foreach (static::getRules() as $rule) {
                $cases[] = [$rule, static::getCompatibleValue(), $params];
            }
        }

        return $cases;
    }

    /**
     * @dataProvider provideIncompatibleParams
     */
    public function testIncompatibleParams(string $rule, mixed $value, mixed $params): void {
        $this -> assertRuleThrows(
            rule: $rule,
            value: $value,
            params: $params,
            expected_exception: ValidationParamsException::class
        );
    }
}
