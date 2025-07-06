<?php

namespace Neimee8\ValidatorPhp\Tests\Rules;

use Neimee8\ValidatorPhp\Tests\Rules\ParamTests\ParamTestPlaceholderTrait;

use Neimee8\ValidatorPhp\Exceptions\ValidationValueException;
use Neimee8\ValidatorPhp\SchemaManager;

abstract class ValueTestCases extends RuleTestCases {
    use ParamTestPlaceholderTrait;

    protected static ?string $rule_group = null;

    abstract protected static function getValueSet(): array;

    abstract protected static function collectCompatibleParams(
        array $specific_param,
        array &$collected_params
    ): void;

    public static function provideIncompatibleValues(): array {
        $rule_format = SchemaManager::getRuleParamFormatByGroup(static::$rule_group);
        $cases = [];

        foreach ($rule_format as $rule => $format) {
            $params = [];

            foreach ($format as $specific_param) {
                static::collectCompatibleParams($specific_param, $params);
            }

            if (count($params) !== count($format)) {
                fwrite(
                    STDOUT,
                    '❗ [WARN] '
                    . static::$rule_group
                    . ' value test incomplete for rule '
                    . $rule
                    . '\n'
                );

                continue;
            }

            foreach (static::getValueSet() as $i => $value) {
                $cases["{$rule}_{$i}"] = [
                    $rule,
                    $value,
                    $params
                ];
            }
        }

        return $cases;
    }

    /**
     * @dataProvider provideIncompatibleValues
     */
    public function testIncompatibleValue(
        string $rule,
        mixed $value,
        array $params
    ): void {
        $this -> assertRuleThrows(
            $rule,
            $value,
            $params,
            ValidationValueException::class
        );
    }
}
