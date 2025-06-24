<?php

namespace Libs\Server\Validation\Validators;

use \ReflectionClass;

use Libs\Server\Validation\Enums\VarType;
use Libs\Server\Validation\Enums\MethodType;

class ValidatorObject {
    use ValidationInvoker;

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

    private static function obj_not_static_var_count(object $value, array $params): bool {
        $reference = $params[0]; // non negative int

        return $reference === self::getVarCount($value, VarType::NOT_STATIC);
    }

    private static function obj_min_not_static_var_count(object $value, array $params): bool {
        $threshold = $params[0]; // non negative int

        return self::getVarCount($value, VarType::NOT_STATIC) >= $threshold;
    }

    private static function obj_max_not_static_var_count(object $value, array $params): bool {
        $threshold = $params[0]; // non negative int

        return self::getVarCount($value, VarType::NOT_STATIC) <= $threshold;
    }

    private static function obj_static_var_count(object $value, array $params): bool {
        $reference = $params[0]; // non negative int

        return $reference === self::getVarCount($value, VarType::STATIC);
    }

    private static function obj_min_static_var_count(object $value, array $params): bool {
        $threshold = $params[0]; // non negative int

        return self::getVarCount($value, VarType::STATIC) >= $threshold;
    }

    private static function obj_max_static_var_count(object $value, array $params): bool {
        $threshold = $params[0]; // non negative int

        return self::getVarCount($value, VarType::STATIC) <= $threshold;
    }

    private static function obj_all_var_count(object $value, array $params): bool {
        $reference = $params[0]; // non negative int

        return $reference === self::getVarCount($value, VarType::ALL);
    }

    private static function obj_min_all_var_count(object $value, array $params): bool {
        $threshold = $params[0]; // non negative int

        return self::getVarCount($value, VarType::ALL) >= $threshold;
    }

    private static function obj_max_all_var_count(object $value, array $params): bool {
        $threshold = $params[0]; // non negative int

        return self::getVarCount($value, VarType::ALL) <= $threshold;
    }

    private static function obj_not_static_method_count(object $value, array $params): bool {
        $reference = $params[0]; // non negative int

        return $reference === self::getMethodCount($value, MethodType::NOT_STATIC);
    }

    private static function obj_min_not_static_method_count(object $value, array $params): bool {
        $threshold = $params[0]; // non negative int

        return self::getMethodCount($value, MethodType::NOT_STATIC) >= $threshold;
    }

    private static function obj_max_not_static_method_count(object $value, array $params): bool {
        $threshold = $params[0]; // non negative int

        return self::getMethodCount($value, MethodType::NOT_STATIC) <= $threshold;
    }

    private static function obj_static_method_count(object $value, array $params): bool {
        $reference = $params[0]; // non negative int

        return $reference === self::getMethodCount($value, MethodType::STATIC);
    }

    private static function obj_min_static_method_count(object $value, array $params): bool {
        $threshold = $params[0]; // non negative int

        return self::getMethodCount($value, MethodType::STATIC) >= $threshold;
    }

    private static function obj_max_static_method_count(object $value, array $params): bool {
        $threshold = $params[0]; // non negative int

        return self::getMethodCount($value, MethodType::STATIC) <= $threshold;
    }

    private static function obj_all_method_count(object $value, array $params): bool {
        $reference = $params[0]; // non negative int

        return $reference === self::getMethodCount($value, MethodType::ALL);
    }

    private static function obj_min_all_method_count(object $value, array $params): bool {
        $threshold = $params[0]; // non negative int

        return self::getMethodCount($value, MethodType::ALL) >= $threshold;
    }

    private static function obj_max_all_method_count(object $value, array $params): bool {
        $threshold = $params[0]; // non negative int

        return self::getMethodCount($value, MethodType::ALL) <= $threshold;
    }

    private static function obj_class_has_parent(object $value, array $params): bool {
        $must_be = $params[0]; // true or false

        return $must_be === (get_parent_class($value) !== false);
    }

    private static function obj_class_implement_count(object $value, array $params): bool {
        $reference = $params[0]; // non negative int

        return $reference === count(class_implements($value));
    }

    private static function obj_class_min_implement_count(object $value, array $params): bool {
        $threshold = $params[0]; // non negative int

        return count(class_implements($value)) >= $threshold;
    }

    private static function obj_class_max_implement_count(object $value, array $params): bool {
        $threshold = $params[0]; // non negative int

        return count(class_implements($value)) <= $threshold;
    }

    private static function obj_class_trait_count(object $value, array $params): bool {
        $reference = $params[0]; // non negative int

        return $reference === count(class_uses($value));
    }

    private static function obj_class_min_trait_count(object $value, array $params): bool {
        $threshold = $params[0]; // non negative int

        return count(class_uses($value)) >= $threshold;
    }

    private static function obj_class_max_trait_count(object $value, array $params): bool {
        $threshold = $params[0]; // non negative int

        return count(class_uses($value)) <= $threshold;
    }

    private static function obj_contains_not_static_var(object $value, array $params): bool {
        $var_name = $params[0]; // string

        return self::containsVar($value, VarType::NOT_STATIC, var_name: $var_name);
    }

    private static function obj_contains_static_var(object $value, array $params): bool {
        $var_name = $params[0]; // string

        return self::containsVar($value, VarType::STATIC, var_name: $var_name);
    }

    private static function obj_contains_var(object $value, array $params): bool {
        $var_name = $params[0]; // string

        return self::containsVar($value, VarType::ALL, var_name: $var_name);
    }

    private static function obj_contains_not_static_method(object $value, array $params): bool {
        $method_name = $params[0]; // string

        return self::containsMethod($value, MethodType::NOT_STATIC, method_name: $method_name);
    }

    private static function obj_contains_static_method(object $value, array $params): bool {
        $method_name = $params[0]; // string

        return self::containsMethod($value, MethodType::STATIC, method_name: $method_name);
    }

    private static function obj_contains_method(object $value, array $params): bool {
        $method_name = $params[0]; // string

        return self::containsMethod($value, MethodType::ALL, method_name: $method_name);
    }

    private static function obj_class_has_specific_parent(object $value, array $params): bool {
        $parent_name = $params[0]; // string
        $class_parent = get_parent_class($value);

        return $parent_name === $class_parent;
    }

    private static function obj_class_has_specific_implement(object $value, array $params): bool {
        $implement_name = $params[0]; // string
        $class_implement_array = class_implements($value);

        return in_array($implement_name, $class_implement_array, strict: true);
    }

    private static function obj_class_has_specific_trait(object $value, array $params): bool {
        $trait_name = $params[0]; // string
        $class_trait_array = class_uses($value);

        return in_array($trait_name, $class_trait_array, strict: true);
    }

    private static function obj_not_contains_not_static_var(object $value, array $params): bool {
        return !self::obj_contains_not_static_var($value, $params);
    }

    private static function obj_not_contains_static_var(object $value, array $params): bool {
        return !self::obj_contains_static_var($value, $params);
    }

    private static function obj_not_contains_var(object $value, array $params): bool {
        return !self::obj_contains_var($value, $params);
    }

    private static function obj_not_contains_not_static_method(object $value, array $params): bool {
        return !self::obj_contains_not_static_method($value, $params);
    }

    private static function obj_not_contains_static_method(object $value, array $params): bool {
        return !self::obj_contains_static_method($value, $params);
    }

    private static function obj_not_contains_method(object $value, array $params): bool {
        return !self::obj_contains_method($value, $params);
    }

    private static function obj_class_has_no_specific_parent(object $value, array $params): bool {
        return !self::obj_class_has_specific_parent($value, $params);
    }

    private static function obj_class_has_no_specific_implement(object $value, array $params): bool {
        return !self::obj_class_has_specific_implement($value, $params);
    }

    private static function obj_class_has_no_specific_trait(object $value, array $params): bool {
        return !self::obj_class_has_specific_trait($value, $params);
    }
}
