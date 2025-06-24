<?php

namespace Neimee8\ValidatorPhp\Validators;

class ValidatorResource {
    use ValidationInvoker;

    private static function resource_type_match($value, array $params): bool {
        $type = $params[0]; // string

        return get_resource_type($value) === $type;
    }

    private static function resource_type_not_match($value, array $params): bool {
        return !self::resource_type_match($value, $params);
    }
}
