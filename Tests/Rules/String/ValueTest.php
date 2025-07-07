<?php

namespace Neimee8\ValidatorPhp\Tests\Rules\String;

use Neimee8\ValidatorPhp\Tests\Rules\ValueTestCases;

/**
 * @group rules
 * @group string
 */
class ValueTest extends ValueTestCases {
    protected static ?string $rule_group = 'string';

    protected static function getValueSet(): array {
        return [
            1,
            0.5,
            true,
            false,
            fn () => true,
            new class {},
            null,
            [1, 2, 3]
        ];
    }

    protected static function collectCompatibleParams(
        array $specific_param,
        array &$collected_params
    ): void {
        if (
            ($specific_param['type'] ?? null) === 'int'
            && ($specific_param['num_positive_zero'] ?? null) === true
        ) {
            $collected_params[] = 3;
        } elseif (($specific_param['type'] ?? null) === 'bool') {
            $collected_params[] = true;
        } elseif (
            ($specific_param['type'] ?? null) === 'string'
            && ($specific_param['str_is_regex'] ?? null) === true
        ) {
            $collected_params[] = '/regex/i';
        } elseif (($specific_param['type'] ?? null) === 'string') {
            $collected_params[] = 'some_string';
        }
    }
}
