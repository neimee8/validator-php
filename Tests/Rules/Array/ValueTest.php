<?php

namespace Neimee8\ValidatorPhp\Tests\Rules\Array;

use Neimee8\ValidatorPhp\Tests\Rules\ValueTestCases;

class ValueTest extends ValueTestCases {
    protected static ?string $rule_group = 'array';

    protected static function getValueSet(): array {
        return [
            1,
            1.5,
            'some_string',
            true,
            false,
            fn () => true,
            new class {},
            null
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
        } elseif (($specific_param['type'] ?? null) === 'array') {
            $collected_params[] = [1, 2, 3];
        } elseif (($specific_param['types'] ?? null) === ['string', 'int']) {
            $collected_params[] = 'some_string';
        } elseif (($specific_param['type'] ?? null) === 'mixed') {
            $collected_params[] = null;
        } elseif (($specific_param['type'] ?? null) === 'bool') {
            $collected_params[] = true;
        } elseif (
            ($specific_param['type'] ?? null) === 'array'
            && ($specific_param['arr_is_indexed'] ?? null) === true
            && ($specific_param['arr_value_type'] ?? null) === 'string'
        ) {
            $collected_params[] = 'int';
        } elseif (($specific_param['type'] ?? null) === 'string') {
            $collected_params[] = 'some_string';
        }
    }
}
