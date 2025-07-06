<?php

namespace Neimee8\ValidatorPhp\Tests\Rules\Numeric;

use Neimee8\ValidatorPhp\Tests\Rules\ValueTestCases;

class ValueTest extends ValueTestCases {
    protected static ?string $rule_group = 'numeric';

    protected static function getValueSet(): array {
        return [
            'some_string',
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
        if (($specific_param['type'] ?? null) === 'bool') {
            $collected_params[] = true;
        } elseif (($specific_param['types'] ?? null) === ['int', 'float']) {
            $collected_params[] = 5;
        }
    }
}
