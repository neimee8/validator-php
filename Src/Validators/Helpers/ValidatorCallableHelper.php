<?php

declare(strict_types = 1);

namespace Neimee8\ValidatorPhp\Validators\Helpers;

use \ReflectionMethod;
use \ReflectionFunction;
use \ReflectionFunctionAbstract;

use Neimee8\ValidatorPhp\Enums\ArgType;

trait ValidatorCallableHelper {
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
}
