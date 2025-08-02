<?php

declare(strict_types = 1);

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
        $is_num = self::validate(
            rule: $local_rule,
            value: $string
        );

        if (!$is_num) {
            return false;
        }

        $casted = null;

        switch ($num_type) {
            case NumType::INT:
                $casted = (int) $string;
                break;
            
            case NumType::FLOAT:
                $casted = (float) $string;
                break;

            case NumType::NUMERIC:
                if (str_contains($string, '.')) {
                    $casted = (float) $string;
                } else {
                    $casted = (int) $string;
                }

                break;
        }

        return ValidatorNumeric::validate(
            rule: 'num_' . $rule,
            value: $casted
        );
    }
}
