<?php

namespace Neimee8\ValidatorPhp\Tests\Rules;

use Neimee8\ValidatorPhp\Tests\Rules\ParamTests\TestBoolParamsTrait;

abstract class MustBeRuleTestCases extends RuleTestCases {
    use TestBoolParamsTrait;

    abstract protected static function getValuesToPass(): array;
    abstract protected static function getValuesToFail(): array;

    public function testPasses(): void {
        if (count(static::getValuesToPass()) === 0) {
            $this -> assertPlaceholder();

            return;
        }

        foreach (static::getValuesToPass() as $value) {
            foreach (static::$rules as $rule) {
                $this -> assertRulePasses(
                    rule: $rule,
                    value: $value,
                    params: true
                );

                $this -> assertRuleFails(
                    rule: $rule,
                    value: $value,
                    params: false
                );
            }
        }
    }

    public function testFails(): void {
        if (count(static::getValuesToFail()) === 0) {
            $this -> assertPlaceholder();

            return;
        }

        foreach (static::getValuesToFail() as $value) {
            foreach (static::$rules as $rule) {
                $this -> assertRuleFails(
                    rule: $rule,
                    value: $value,
                    params: true
                );

                $this -> assertRulePasses(
                    rule: $rule,
                    value: $value,
                    params: false
                );
            }
        }
    }
}
