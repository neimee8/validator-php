<?php

namespace Neimee8\ValidatorPhp\Validators;

use \ReflectionMethod;
use \ReflectionFunction;
use \ReflectionFunctionAbstract;

use Neimee8\ValidatorPhp\Enums\ArgType;

class ValidatorCallable {
    use ValidationInvoker;
    
    private static function getRef(callable $callable): ReflectionFunctionAbstract {
        if (is_array($callable)) {
            return new ReflectionMethod($callable[0], $callable[1]);
        } elseif (is_string($callable)) {
            if (str_contains($callable, '::')) {
                [$class, $method] = explode('::', $callable, 2);

                return new ReflectionMethod($class, $method);
            }
        } elseif ($callable instanceof \Closure) {
            return new ReflectionFunction($callable);
        } elseif (is_object($callable) && method_exists($callable, '__invoke')) {
            return new ReflectionMethod($callable, '__invoke');
        }

        return new ReflectionFunction($callable);
    }

    private static function paramCount(callable $callable, ArgType $arg_type): int {
        $ref = self::getRef($callable);
        $count = 0;

        switch ($arg_type) {
            case ArgType::ALL:
                $count = $ref -> getNumberOfParameters();
                break;
            case ArgType::REQ:
                $count = $ref -> getNumberOfRequiredParameters();
                break;
            case ArgType::NOT_REQ:
                $count = $ref -> getNumberOfParameters() - $ref -> getNumberOfRequiredParameters();
                break;
        }

        return $count;
    }

    private static function containsArg(callable $callable, ArgType $arg_type, string $arg_name): bool {
        $ref = self::getRef($callable);

        foreach ($ref -> getParameters() as $arg) {
            $validArg = $arg_type === ArgType::ALL
                || ($arg_type === ArgType::REQ && !$arg -> isOptional())
                || ($arg_type === ArgType::NOT_REQ && $arg -> isOptional());

            if ($validArg && $arg_name === $arg -> getName()) {
                return true;
            }
        }

        return false;
    }

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
