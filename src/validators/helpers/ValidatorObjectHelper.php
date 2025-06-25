<?php

namespace Neimee8\ValidatorPhp\Validators\Helpers;

use \ReflectionClass;

use Neimee8\ValidatorPhp\Enums\VarType;
use Neimee8\ValidatorPhp\Enums\MethodType;

trait ValidatorObjectHelper {
    private static function getVarNameArray(object $object): array {
        $ref = new ReflectionClass($object);

        $vars = [
            VarType::STATIC -> value => [],
            VarType::NOT_STATIC -> value => []
        ];

        foreach ($ref -> getProperties() as $var) {
            $vars[
                $var -> isStatic()
                    ? VarType::STATIC -> value
                    : VarType::NOT_STATIC -> value
            ][] = $var -> getName();
        }

        foreach (get_object_vars($object) as $var_name) {
            if (!in_array($var_name, $vars[VarType::NOT_STATIC -> value], strict: true)) {
                $vars[VarType::NOT_STATIC -> value][] = $var_name;
            }
        }

        return $vars;
    }

    private static function getVarCount(object $object, VarType $var_type): int {
        $vars = self::getVarNameArray($object);

        return $var_type === VarType::ALL
            ? count($vars[VarType::STATIC -> value]) + count($vars[VarType::NOT_STATIC -> value])
            : count($vars[$var_type -> value]);
    }

    private static function containsVar(object $object, VarType $var_type, string $var_name): bool {
        $vars = self::getVarNameArray($object);

        return $var_type === VarType::ALL
            ? in_array($var_name, $vars[VarType::STATIC -> value], strict: true) 
                || in_array($var_name, $vars[VarType::NOT_STATIC -> value], strict: true)
            : in_array($var_name, $vars[$var_type -> value], strict: true);
    }

    private static function getMethodCount(object $object, MethodType $method_type): int {
        $ref = new ReflectionClass($object);

        $methods = [];

        if ($method_type === MethodType::ALL) {
            $methods = $ref -> getMethods();
        } elseif ($method_type === MethodType::STATIC) {
            $methods = array_filter(
                $ref -> getMethods(),
                fn($method) => $method -> isStatic()
            );
        } elseif ($method_type === MethodType::NOT_STATIC) {
            $methods = array_filter(
                $ref -> getMethods(),
                fn($method) => !$method -> isStatic()
            );
        }

        return count($methods);
    }

    private static function containsMethod(object $object, MethodType $method_type, string $method_name): bool {
        $ref = new ReflectionClass($object);

        foreach ($ref -> getMethods() as $method) {
            if ($method -> getName() === $method_name) {
                if (
                    $method_type === MethodType::ALL
                    || ($method_type === MethodType::STATIC && $method -> isStatic())
                    || ($method_type === MethodType::NOT_STATIC && !$method -> isStatic())
                ) {
                    return true;
                }

            }
        }

        return false;
    }
}
