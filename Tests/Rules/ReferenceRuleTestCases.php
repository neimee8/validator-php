<?php

namespace Neimee8\ValidatorPhp\Tests\Rules;

abstract class ReferenceRuleTestCases extends RuleTestCases {
    protected array $references = [];

    abstract protected static function getValuesToPass(): array;
    abstract protected static function getValuesToFail(): array;

    public function testPasses(): void {
        if (count(static::getValuesToPass()) === 0) {
            $this -> assertPlaceholder();

            return;
        }

        foreach (static::getValuesToPass() as $value) {

            foreach (static::$rules as $rule) {

                foreach ($this -> references as $reference) {
                    $this -> assertRulePasses(
                        rule: $rule,
                        value: $value,
                        params: $reference
                    );
                }

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

                foreach ($this -> references as $reference) {
                    $this -> assertRuleFails(
                        rule: $rule,
                        value: $value,
                        params: $reference
                    );
                }
                
            }

        }
    }
}
