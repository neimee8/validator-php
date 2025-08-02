<?php

declare(strict_types = 1);

namespace Neimee8\ValidatorPhp\Validators;

use Neimee8\ValidatorPhp\Validators\Helpers\ValidatorHelper;
use Neimee8\ValidatorPhp\Validators\Helpers\ValidatorArrayHelper;

use Neimee8\ValidatorPhp\Validators\ValidatorGeneral;

final class ValidatorArray {
    use ValidatorHelper, ValidatorArrayHelper;

    private static function arr_len(array $value, array $params): bool {
        return count($value) === $params['size'];
    }

    private static function arr_min_len(array $value, array $params): bool {
        return count($value) >= $params['size'];
    }

    private static function arr_max_len(array $value, array $params): bool {
        return count($value) <= $params['size'];
    }

    private static function arr_intersects(array $value, array $params): bool {
        return count(array_intersect($value, $params['reference'])) > 0;
    }

    private static function arr_subset(array $value, array $params): bool {
        if ($params['unique']) {
            $value = self::array_unique_strict($value, $params['strict']);
            $superset = self::array_unique_strict($params['superset'], $params['strict']);
        }

        $result = count(
            array_udiff(
                $value,
                $superset,
                function ($a, $b) use ($params) {
                    return $params['strict'] ? ($a === $b ? 0 : 1) : ($a == $b ? 0 : 1);
                }
            )
        ) === 0;

        if ($params['strict_set']) {
            $result = $result && (count($value) < count($superset));
        }

        return $result;
    }

    private static function arr_superset(array $value, array $params): bool {
        if ($params['unique']) {
            $value = self::array_unique_strict($value, $params['strict']);
            $subset = self::array_unique_strict($params['subset'], $params['strict']);
        }

        $result = count(
            array_udiff(
                $subset,
                $value,
                function ($a, $b) use ($params) {
                    return $params['strict'] ? ($a === $b ? 0 : 1) : ($a == $b ? 0 : 1);
                }
            )
        ) === 0;

        if ($params['strict_set']) {
            $result = $result && (count($value) > count($subset));
        }

        return $result;
    }

    private static function arr_contains_key(array $value, array $params): bool {
        return in_array($params['needle'], array_keys($params['needle'], $value), $params['strict']);
    }

    private static function arr_contains_value(array $value, array $params): bool {
        return in_array($params['needle'], $value, $params['strict']);
    }

    private static function arr_assoc(array $value, array $params): bool {
        if (count($value) === 0) {
            return true;
        }

        $indexed_keys = range(0, count($value) - 1);
        $actual_keys = array_keys($value);

        return $indexed_keys !== $actual_keys;
    }

    private static function arr_indexed(array $value, array $params): bool {
        if (count($value) === 0) {
            return true;
        }

        return !self::validate('arr_assoc', $value, $params);
    }

    private static function arr_nested(array $value, array $params): bool {
        foreach ($value as $element) {
            if (is_array($element)) {
                return true;
            }
        }

        return false;
    }

    private static function arr_values_unique(array $value, array $params): bool {
        $unique_array = array_unique($value);

        return count($value) === count($unique_array);
    }

    private static function arr_value_types(array $value, array $params): bool {
        foreach ($value as $element) {
            if (
                ValidatorGeneral::validate(
                    rule: 'types',
                    value: $element,
                    params: [
                        'types' => $params['types'],
                        'invert' => true
                    ]
                )
            ) {
                return false;
            }
        }

        return true;
    }

    private static function arr_value_type(array $value, array $params): bool {
        return self::validate(
            rule: 'arr_value_types',
            value: $value,
            params: [
                'types' => [$params['type']]
            ]
        );
    }
}
