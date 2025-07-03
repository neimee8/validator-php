<?php

namespace Neimee8\ValidatorPhp\Tests;

trait DataTypeManager {
    private static array $ALL_DATA_TYPES = [
        'mixed',
        'null',
        'int',
        '?int',
        'float',
        '?float',
        'string',
        '?string',
        'bool',
        '?bool',
        'array',
        '?array',
        'callable',
        '?callable',
        'object',
        '?object',
        'resource',
        '?resource',
        'iterable',
        '?iterable',
    ];

    private static function filterDataTypes(array $types): array {
        return array_values(
            array_filter(
                self::$ALL_DATA_TYPES,
                fn ($type) => !in_array($type, [...$types, 'mixed'])
            )
        );
    }
}
