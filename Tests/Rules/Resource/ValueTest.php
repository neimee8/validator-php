<?php

namespace Neimee8\ValidatorPhp\Tests\Rules\Resource;

use Neimee8\ValidatorPhp\Tests\Rules\ValueTestCases;

class ValueTest extends ValueTestCases {
    protected static ?string $rule_group = 'resource';

    protected static function getValueSet(): array {
        return [
            1,
            1.5,
            'some_string',
            true,
            false,
            fn () => true,
            new class {},
            [1, 2, 3],
            null
        ];
    }

    protected static function collectCompatibleParams(
        array $specific_param,
        array &$collected_params
    ): void {
        if (($specific_param['type'] ?? null) === 'string') {
            $collected_params[] = 'some_string';
        }
    }
}
