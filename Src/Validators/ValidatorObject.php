<?php

declare(strict_types = 1);

namespace Neimee8\ValidatorPhp\Validators;

use Neimee8\ValidatorPhp\Enums\VarType;
use Neimee8\ValidatorPhp\Enums\MethodType;

use Neimee8\ValidatorPhp\Validators\Helpers\ValidatorHelper;
use Neimee8\ValidatorPhp\Validators\Helpers\ValidatorObjectHelper;

final class ValidatorObject {
    use ValidatorHelper, ValidatorObjectHelper;

    private static function obj_var_count(object $value, array $params): bool {
        return self::getVarCount($value, VarType::ALL) === $params['size'];
    }

    private static function obj_min_var_count(object $value, array $params): bool {
        return self::getVarCount($value, VarType::ALL) >= $params['size'];
    }

    private static function obj_max_var_count(object $value, array $params): bool {
        return self::getVarCount($value, VarType::ALL) <= $params['size'];
    }

    private static function obj_not_static_var_count(object $value, array $params): bool {
        return self::getVarCount($value, VarType::NOT_STATIC) === $params['size'];
    }

    private static function obj_min_not_static_var_count(object $value, array $params): bool {
        return self::getVarCount($value, VarType::NOT_STATIC) >= $params['size'];
    }

    private static function obj_max_not_static_var_count(object $value, array $params): bool {
        return self::getVarCount($value, VarType::NOT_STATIC) <= $params['size'];
    }

    private static function obj_static_var_count(object $value, array $params): bool {
        return self::getVarCount($value, VarType::STATIC) === $params['size'];
    }

    private static function obj_min_static_var_count(object $value, array $params): bool {
        return self::getVarCount($value, VarType::STATIC) >= $params['size'];
    }

    private static function obj_max_static_var_count(object $value, array $params): bool {
        return self::getVarCount($value, VarType::STATIC) <= $params['size'];
    }

    private static function obj_method_count(object $value, array $params): bool {
        return self::getMethodCount($value, MethodType::ALL) === $params['size'];
    }

    private static function obj_min_method_count(object $value, array $params): bool {
        return self::getMethodCount($value, MethodType::ALL) >= $params['size'];
    }

    private static function obj_max_method_count(object $value, array $params): bool {
        return self::getMethodCount($value, MethodType::ALL) <= $params['size'];
    }

    private static function obj_not_static_method_count(object $value, array $params): bool {
        return self::getMethodCount($value, MethodType::NOT_STATIC) === $params['size'];
    }

    private static function obj_min_not_static_method_count(object $value, array $params): bool {
        return self::getMethodCount($value, MethodType::NOT_STATIC) >= $params['size'];
    }

    private static function obj_max_not_static_method_count(object $value, array $params): bool {
        return self::getMethodCount($value, MethodType::NOT_STATIC) <= $params['size'];
    }

    private static function obj_static_method_count(object $value, array $params): bool {
        return self::getMethodCount($value, MethodType::STATIC) === $params['size'];
    }

    private static function obj_min_static_method_count(object $value, array $params): bool {
        return self::getMethodCount($value, MethodType::STATIC) >= $params['size'];
    }

    private static function obj_max_static_method_count(object $value, array $params): bool {
        return self::getMethodCount($value, MethodType::STATIC) <= $params['size'];
    }

    private static function obj_class_interface_count(object $value, array $params): bool {
        return count(class_implements($value)) === $params['size'];
    }

    private static function obj_class_min_interface_count(object $value, array $params): bool {
        return count(class_implements($value)) >= $params['size'];
    }

    private static function obj_class_max_interface_count(object $value, array $params): bool {
        return count(class_implements($value)) <= $params['size'];
    }

    private static function obj_class_trait_count(object $value, array $params): bool {
        return count(class_uses($value)) === $params['size'];
    }

    private static function obj_class_min_trait_count(object $value, array $params): bool {
        return count(class_uses($value)) >= $params['size'];
    }

    private static function obj_class_max_trait_count(object $value, array $params): bool {
        return count(class_uses($value)) <= $params['size'];
    }

    private static function obj_class_has_parent(object $value, array $params): bool {
        return get_parent_class($value) !== false;
    }

    private static function obj_contains_var(object $value, array $params): bool {
        return self::containsVar($value, VarType::ALL, var_name: $params['needle']);
    }

    private static function obj_contains_not_static_var(object $value, array $params): bool {
        return self::containsVar($value, VarType::NOT_STATIC, var_name: $params['needle']);
    }

    private static function obj_contains_static_var(object $value, array $params): bool {
        return self::containsVar($value, VarType::STATIC, var_name: $params['needle']);
    }

    private static function obj_contains_method(object $value, array $params): bool {
        return self::containsMethod($value, MethodType::ALL, method_name: $params['needle']);
    }

    private static function obj_contains_not_static_method(object $value, array $params): bool {
        return self::containsMethod($value, MethodType::NOT_STATIC, method_name: $params['needle']);
    }

    private static function obj_contains_static_method(object $value, array $params): bool {
        return self::containsMethod($value, MethodType::STATIC, method_name: $params['needle']);
    }

    private static function obj_class_has_specific_parent(object $value, array $params): bool {
        $class_parent = get_parent_class($value);

        return $class_parent === $params['reference'];
    }

    private static function obj_class_has_specific_interface(object $value, array $params): bool {
        $class_implement_array = class_implements($value);

        return in_array($params['needle'], $class_implement_array, strict: true);
    }

    private static function obj_class_has_specific_trait(object $value, array $params): bool {
        $class_trait_array = class_uses($value);

        return in_array($params['needle'], $class_trait_array, strict: true);
    }
}
