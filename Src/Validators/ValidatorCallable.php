<?php

declare(strict_types = 1);

namespace Neimee8\ValidatorPhp\Validators;

use Neimee8\ValidatorPhp\Enums\ArgType;

use Neimee8\ValidatorPhp\Validators\Helpers\ValidatorHelper;
use Neimee8\ValidatorPhp\Validators\Helpers\ValidatorCallableHelper;

final class ValidatorCallable {
    use ValidatorHelper, ValidatorCallableHelper;

    private static function call_arg_count(callable $value, array $params): bool {
        return self::paramCount($value, ArgType::ALL) === $params['size'];
    }

    private static function call_min_arg_count(callable $value, array $params): bool {
        return self::paramCount($value, ArgType::ALL) >= $params['size'];
    }

    private static function call_max_arg_count(callable $value, array $params): bool {
        return self::paramCount($value, ArgType::ALL) <= $params['size'];
    }

    private static function call_req_arg_count(callable $value, array $params): bool {
        return self::paramCount($value, ArgType::REQ) === $params['size'];
    }

    private static function call_min_req_arg_count(callable $value, array $params): bool {
        return self::paramCount($value, ArgType::REQ) >= $params['size'];
    }

    private static function call_max_req_arg_count(callable $value, array $params): bool {
        return self::paramCount($value, ArgType::REQ) <= $params['size'];
    }

    private static function call_not_req_arg_count(callable $value, array $params): bool {
        return self::paramCount($value, ArgType::NOT_REQ) === $params['size'];
    }

    private static function call_min_not_req_arg_count(callable $value, array $params): bool {
        return self::paramCount($value, ArgType::NOT_REQ) >= $params['size'];
    }

    private static function call_max_not_req_arg_count(callable $value, array $params): bool {
        return self::paramCount($value, ArgType::NOT_REQ) <= $params['size'];
    }

    private static function call_contains_arg(callable $value, array $params): bool {
        return self::containsArg($value, ArgType::ALL, arg_name: $params['needle']);
    }

    private static function call_contains_req_arg(callable $value, array $params): bool {
        return self::containsArg($value, ArgType::REQ, arg_name: $params['needle']);
    }

    private static function call_contains_not_req_arg(callable $value, array $params): bool {
        return self::containsArg($value, ArgType::NOT_REQ, arg_name: $params['needle']);
    }
}
