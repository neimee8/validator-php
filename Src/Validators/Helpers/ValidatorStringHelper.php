<?php

namespace Neimee8\ValidatorPhp\Validators\Helpers;

use Neimee8\ValidatorPhp\Enums\NumType;
use Neimee8\ValidatorPhp\Validators\ValidatorNumeric;

trait ValidatorStringHelper {
    private static function strRegex(string $string, string $pattern): bool {
        return preg_match($pattern, $string) === 1;
    }

    private static function strFilter(string $string, ...$filter): bool {
        return filter_var($string, ...$filter) !== false;
    }

    private static function strNum(string $string, NumType $num_type, string $rule): bool {
        $local_rule = 'str_' . $num_type -> value;
        $is_num = self::$local_rule($string, [true]);

        if (!$is_num) {
            return false;
        }

        $casted = $num_type === NumType::INT
            ? (int) $string
            : (float) $string;

        return ValidatorNumeric::validate('num_' . $num_type -> value, $casted, [true]);
    }
}
