<?php

namespace Neimee8\ValidatorPhp\Validators\Helpers;

use \ReflectionClass;

use Neimee8\ValidatorPhp\Enums\VarType;
use Neimee8\ValidatorPhp\Enums\MethodType;

trait ValidatorObjectHelper {
    private static function getVarNameArray(object $object): array {
        $ref = new ReflectionClass($object);

        $vars = [
            'static' => [],
            'not_static' => []
        ];

        foreach ($ref -> getProperties() as $var) {
            $vars[$var -> isStatic() ? 'static' : 'not_static'][] = $var -> getName();
        }

        foreach (get_object_vars($object) as $var_name) {
            if (!in_array($var_name, $vars['static'], strict: true)) {
                $vars['not_static'][] = $var_name;
            }
        }

        return $vars;
    }

    private static function getVarCount(object $object, VarType $var_type): int {
        $vars = self::getVarNameArray($object);

        return $var_type === 'all'
            ? count($vars['static']) + count($vars['not_static'])
            : count($vars[$var_type]);
    }

    private static function containsVar(object $object, VarType $var_type, string $var_name): bool {
        $vars = self::getVarNameArray($object);

        return $var_type === 'all'
            ? in_array($var_name, $vars['static'], strict: true) 
                || in_array($var_name, $vars['not_static'], strict: true)
            : in_array($var_name, $vars[$var_type], strict: true);
    }

    private static function getMethodCount(object $object, MethodType $method_type): int {
        $ref = new ReflectionClass($object);

        $methods = [];

        if ($method_type === 'all') {
            $methods = $ref -> getMethods();
        } elseif ($method_type === 'static') {
            $methods = array_filter(
                $ref -> getMethods(),
                fn($method) => $method -> isStatic()
            );
        } elseif ($method_type === 'not_static') {
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
                    $method_type === 'all'
                    || ($method_type === 'static' && $method -> isStatic())
                    || ($method_type === 'not_static' && !$method -> isStatic())
                ) {
                    return true;
                }

            }
        }

        return false;
    }
}
