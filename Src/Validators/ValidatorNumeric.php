<?php

declare(strict_types = 1);

namespace Neimee8\ValidatorPhp\Validators;

use Neimee8\ValidatorPhp\Validators\Helpers\ValidatorHelper;

final class ValidatorNumeric {
    use ValidatorHelper;

    private static function num_positive(int|float $value, array $params): bool {
        return $value > 0;
    }

    private static function num_positive_zero(int|float $value, array $params): bool {
        return $value >= 0;
    }

    private static function num_negative(int|float $value, array $params): bool {
        return $value < 0;
    }

    private static function num_negative_zero(int|float $value, array $params): bool {
        return $value <= 0;
    }

    private static function num_more_than(int|float $value, array $params): bool {
        return $value > $params['threshold'];
    }

    private static function num_more_or_equal(int|float $value, array $params): bool {
        return $value >= $params['threshold'];
    }

    private static function num_less_than(int|float $value, array $params): bool {
        return $value < $params['threshold'];
    }

    private static function num_less_or_equal(int|float $value, array $params): bool {
        return $value <= $params['threshold'];
    }
}
