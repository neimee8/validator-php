<?php

namespace Neimee8\ValidatorPhp\Validators;

use Neimee8\ValidatorPhp\Validators\Helpers\ValidationInvoker;
use Neimee8\ValidatorPhp\Validators\ValidatorGeneral;

class ValidatorArray {
    use ValidationInvoker;

    private static function arr_len(array $value, array $params): bool {
        $reference = $params[0]; // non negative int

        return count($value) === $reference;
    }

    private static function arr_min_len(array $value, array $params): bool {
        $threshold = $params[0]; // non negative int

        return count($value) >= $threshold;
    }

    private static function arr_max_len(array $value, array $params): bool {
        $threshold = $params[0]; // non negative int

        return count($value) <= $threshold;
    }

    private static function arr_intersects(array $value, array $params): bool {
        $array = $params[0]; // array

        return count(array_intersect($value, $array)) > 0;
    }

    private static function arr_is_subset(array $value, array $params): bool {
        $superset = $params[0]; // array

        return count(array_diff($value, $superset)) === 0;
    }

    private static function arr_is_strict_subset(array $value, array $params): bool {
        $superset = $params[0]; // array

        return count(array_diff($value, $superset)) === 0 && (count($value) < count($superset));
    }

    private static function arr_is_superset(array $value, array $params): bool {
        $subset = $params[0]; // array

        return count(array_diff($subset, $value)) === 0;
    }

    private static function arr_is_strict_superset(array $value, array $params): bool {
        $subset = $params[0]; // array

        return count(array_diff($subset, $value)) === 0 && (count($subset) < count($value));
    }

    private static function arr_no_intersection(array $value, array $params): bool {
        return !self::arr_intersects($value, $params);
    }

    private static function arr_not_subset(array $value, array $params): bool {
        return !self::arr_is_subset($value, $params);
    }

    private static function arr_not_strict_subset(array $value, array $params): bool {
        return !self::arr_is_strict_subset($value, $params);
    }

    private static function arr_not_superset(array $value, array $params): bool {
        return !self::arr_is_superset($value, $params);
    }

    private static function arr_not_strict_superset(array $value, array $params): bool {
        return !self::arr_is_strict_superset($value, $params);
    }

    private static function arr_contains_key(array $value, array $params): bool {
        $needle = $params[0]; // mixed

        return array_key_exists($needle, $value);
    }

    private static function arr_contains_value(array $value, array $params): bool {
        $needle = $params[0]; // mixed

        return in_array($needle, array_values($value), strict: true);
    }

    private static function arr_not_contains_key(array $value, array $params): bool {
        return !self::arr_contains_key($value, $params);
    }

    private static function arr_not_contains_value(array $value, array $params): bool {
       return !self::arr_contains_value($value, $params);
    }

    private static function arr_is_assoc(array $value, array $params): bool {
        $must_be = $params[0]; // true or false

        $indexed_keys = range(0, count($value) - 1);
        $actual_keys = array_keys($value);

        return $must_be === ($indexed_keys !== $actual_keys);
    }

    private static function arr_is_indexed(array $value, array $params): bool {
        return !self::arr_is_assoc($value, $params);
    }

    private static function arr_is_nested(array $value, array $params): bool {
        $must_be = $params[0]; // true or false

        foreach ($value as $element) {
            if (is_array($element)) {
                return $must_be;
            }
        }

        return !$must_be;
    }

    private static function arr_is_unique(array $value, array $params): bool {
        $must_be = $params[0]; // true or false
        $unique_array = array_unique($value);

        return $must_be === (count($value) === count($unique_array));
    }

    private static function arr_value_types(array $value, array $params): bool {
        $types = $params[0]; // array of string types

        foreach ($value as $element) {
            if (!ValidatorGeneral::validate('types', $element, [$types])) {
                return false;
            }
        }

        return true;
    }

    private static function arr_value_type(array $value, array $params): bool {
        $type = $params[0]; // string type

        return self::arr_value_types($value, [[$type]]);
    }

    private static function arr_not_value_types(array $value, array $params): bool {
        return !self::arr_value_types($value, $params);
    }

    private static function arr_not_value_type(array $value, array $params): bool {
        return !self::arr_value_type($value, $params);
    }
}
