<?php

namespace Neimee8\ValidatorPhp\Tests\Rules\Callable;

use Neimee8\ValidatorPhp\Tests\Rules\ValueTestCases;

/**
 * @group rules
 * @group callable
 */
class ValueTest extends ValueTestCases {
    protected static ?string $rule_group = 'callable';

    protected static function getValueSet(): array {
        return [
            1,
            1.5,
            'some_string',
            true,
            false,
            [1, 2, 3],
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
        } elseif (($specific_param['type'] ?? null) === 'string') {
            $collected_params[] = 'some_string';
        }
    }
}
