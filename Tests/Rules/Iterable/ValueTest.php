<?php

namespace Neimee8\ValidatorPhp\Tests\Rules\Iterable;

use Neimee8\ValidatorPhp\Tests\Rules\ValueTestCases;

/**
 * @group rules
 * @group iterable
 */
class ValueTest extends ValueTestCases {
    protected static ?string $rule_group = 'iterable';

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
        if (($specific_param['type'] ?? null) === 'bool') {
            $collected_params[] = true;
        }
    }
}
