<?php

namespace Neimee8\ValidatorPhp\Validators;

class ValidatorNumeric {
    use ValidationInvoker;

    private static function num_positive(int|float $value, array $params): bool {
        $must_be = $params[0]; // true or false

        return $must_be === ($value > 0);
    }

    private static function num_positive_zero(int|float $value, array $params): bool {
        $must_be = $params[0]; // true or false

        return $must_be === ($value >= 0);
    }

    private static function num_negative(int|float $value, array $params): bool {
        $must_be = $params[0]; // true or false

        return $must_be === ($value < 0);
    }

    private static function num_negative_zero(int|float $value, array $params): bool {
        $must_be = $params[0]; // true or false

        return $must_be === ($value <= 0);
    }

    private static function num_more_than(int|float $value, array $params): bool {
        $reference = $params[0]; // int or float

        return $value > $reference;
    }

    private static function num_more_or_equal(int|float $value, array $params): bool {
        $reference = $params[0]; // int or float

        return $value >= $reference;
    }

    private static function num_less_than(int|float $value, array $params): bool {
        $reference = $params[0]; // int or float

        return $value < $reference;
    }

    private static function num_less_or_equal(int|float $value, array $params): bool {
        $reference = $params[0]; // int or float

        return $value <= $reference;
    }
}
