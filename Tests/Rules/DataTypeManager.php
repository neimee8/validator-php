<?php

namespace Neimee8\ValidatorPhp\Tests\Rules;

use Neimee8\ValidatorPhp\SchemaManager;

trait DataTypeManager {
    private static ?array $ALL_DATA_TYPES = null;

    private static function getDataTypes(): array {
        if (self::$ALL_DATA_TYPES === null) {
            self::$ALL_DATA_TYPES = SchemaManager::getDataTypes();
        }

        return self::$ALL_DATA_TYPES;
    }

    private static function filterDataTypes(
        array $types,
        bool $filter_nullable = true
    ): array {
        if ($filter_nullable) {
            foreach ($types as $type) {
                if (!str_starts_with($type, '?')) {
                    $types[] = "?$type";
                }
            }
        }

        return array_values(
            array_filter(
                self::getDataTypes(),
                fn ($type) => !in_array($type, [...$types, 'mixed'])
            )
        );
    }

    private static function getNullableDataTypes(): array {
        return [
            ...array_filter(
                self::getDataTypes(),
                fn ($type) => str_starts_with($type, '?')
            ),
            'null'
        ];
    }
}
