<?php

namespace Neimee8\ValidatorPhp\Validators;

use Neimee8\ValidatorPhp\Enums\ArgType;
use Neimee8\ValidatorPhp\Validators\Helpers\ValidationInvoker;
use Neimee8\ValidatorPhp\Validators\Helpers\ValidatorCallableHelper;

class ValidatorCallable {
    use ValidationInvoker, ValidatorCallableHelper;

    private static function callable_arg_count(callable $value, array $params): bool {
        $reference = $params[0]; // non negative int

        return $reference === self::paramCount($value, ArgType::ALL);
    }

    private static function callable_min_arg_count(callable $value, array $params): bool {
        $threshold = $params[0]; // non negative int

        return self::paramCount($value, ArgType::ALL) >= $threshold;
    }

    private static function callable_max_arg_count(callable $value, array $params): bool {
        $threshold = $params[0]; // non negative int

        return self::paramCount($value, ArgType::ALL) <= $threshold;
    }

    private static function callable_req_arg_count(callable $value, array $params): bool {
        $reference = $params[0]; // non negative int

        return $reference === self::paramCount($value, ArgType::REQ);
    }

    private static function callable_min_req_arg_count(callable $value, array $params): bool {
        $threshold = $params[0]; // non negative int

        return self::paramCount($value, ArgType::REQ) >= $threshold;
    }

    private static function callable_max_req_arg_count(callable $value, array $params): bool {
        $threshold = $params[0]; // non negative int

        return self::paramCount($value, ArgType::REQ) <= $threshold;
    }

    private static function callable_not_req_arg_count(callable $value, array $params): bool {
        $reference = $params[0]; // non negative int

        return $reference === self::paramCount($value, ArgType::NOT_REQ);
    }

    private static function callable_min_not_req_arg_count(callable $value, array $params): bool {
        $threshold = $params[0]; // non negative int

        return self::paramCount($value, ArgType::NOT_REQ) >= $threshold;
    }

    private static function callable_max_not_req_arg_count(callable $value, array $params): bool {
        $threshold = $params[0]; // non negative int

        return self::paramCount($value, ArgType::NOT_REQ) <= $threshold;
    }

    private static function callable_contains_arg(callable $value, array $params): bool {
        $arg = $params[0]; // string

        return self::containsArg($value, ArgType::ALL, arg_name: $arg);
    }

    private static function callable_contains_req_arg(callable $value, array $params): bool {
        $arg = $params[0]; // string

        return self::containsArg($value, ArgType::REQ, arg_name: $arg);
    }

    private static function callable_contains_not_req_arg(callable $value, array $params): bool {
        $arg = $params[0]; // string

        return self::containsArg($value, ArgType::NOT_REQ, arg_name: $arg);
    }

    private static function callable_not_contains_arg(callable $value, array $params): bool {
        return !self::callable_contains_arg($value, $params);
    }

    private static function callable_not_contains_req_arg(callable $value, array $params): bool {
        return !self::callable_contains_req_arg($value, $params);
    }

    private static function callable_not_contains_not_req_arg(callable $value, array $params): bool {
        return !self::callable_contains_not_req_arg($value, $params);
    }
}
