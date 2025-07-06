<?php

namespace Neimee8\ValidatorPhp\Tests\Rules\Numeric;

use Neimee8\ValidatorPhp\Tests\Rules\RuleTestCase;
use Neimee8\ValidatorPhp\Tests\Rules\ParamTests\ParamTestPlaceholderTrait;

use Neimee8\ValidatorPhp\Exceptions\ValidationValueException;
use Neimee8\ValidatorPhp\SchemaManager;

class ValueTest extends RuleTestCase {
    use ParamTestPlaceholderTrait;

    public static function provideIncompatibleValues(): array {
        $value_set = [
            'some_string',
            true,
            false,
            fn () => true,
            new class {},
            null,
            [1, 2, 3]
        ];

        $rule_format = SchemaManager::getRuleParamFormatByGroup('numeric');
        $cases = [];

        foreach ($rule_format as $rule => $format) {
            $params = [];

            foreach ($format as $param) {
                if (($param['type'] ?? null) === 'bool') {
                    $params[] = true;
                } elseif (($param['types'] ?? null) === ['int', 'float']) {
                    $params[] = 5;
                }
            }

            if (count($params) !== count($format)) {
                continue;
            }

            foreach ($value_set as $i => $value) {
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
