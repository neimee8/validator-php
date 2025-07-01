<?php

namespace Neimee8\ValidatorPhp;

use Neimee8\ValidatorPhp\Exceptions\ValidationParamsException;
use Neimee8\ValidatorPhp\Exceptions\ValidationValueException;

class Validator {
    private const VALIDATORS_NAMESPACE = '\\Neimee8\\ValidatorPhp\\Validators\\';

    public static function __callStatic(string $rule, array $args) {
        if (!isset($args[0])) {
            throw new ValidationValueException(message: 'Value should be set');
        }

        if (!isset($args[1])) {
            throw new ValidationParamsException();
        }

        $value = $args[0];
        $params = $args[1];

        $rule_type = explode('_', $rule)[0];
        $validators_schema = SchemaManager::getValidators();

        $validator = self::VALIDATORS_NAMESPACE;
        $validator .= ($validators_schema[$rule_type] ?? 'ValidatorGeneral');

        return $validator::validate($rule, $value, $params);
    }
}
