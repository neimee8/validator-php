<?php

namespace Neimee8\ValidatorPhp\Validators\Helpers;

use Neimee8\ValidatorPhp\SchemaManager;
use Neimee8\ValidatorPhp\Validator;

use Neimee8\ValidatorPhp\Exceptions\ValidationRuleException;
use Neimee8\ValidatorPhp\Exceptions\ValidationValueException;
use Neimee8\ValidatorPhp\Exceptions\ValidationParamsException;

trait ValidationInvoker {
    public static function validate(string $rule, mixed $value, mixed $params) {
        ValidationRecursiveDepth::$counter++;

        try {
            if (ValidationRecursiveDepth::$counter < 2) {
                self::validateArgs($rule, $value, $params);
            }

            return self::$rule($value, $params);
        } finally {
            ValidationRecursiveDepth::$counter--;
        }
    }

    private static function validateArgs(string $rule, mixed $value, mixed &$params) {
        $class = explode('\\', get_class());
        $rule_group = strtolower(
            substr(
                $class[count($class) - 1],
                strlen('Validator')
            )
        );
        
        $rule_param_format_schema = SchemaManager::getRuleParamFormatByGroup($rule_group);
        $rule_validation = Validator::value_in($rule, [array_keys($rule_param_format_schema)]);
        
        if (!$rule_validation) {
            throw new ValidationRuleException(rule: $rule);
        }

        if ($rule_group !== 'general') {
            $allowed_type_group = SchemaManager::getTypesOfGroup($rule_group, nullable: false);
            $value_validation = Validator::types($value, [$allowed_type_group]);

            if (!$value_validation) {
                throw new ValidationValueException(rule: $rule, value: $value);
            }
        }

        $rule_param_format = $rule_param_format_schema[$rule];
        self::normalizeParams($params, $rule_param_format);

        $params_type_validation = Validator::types($params, [['array']])
            && Validator::arr_is_indexed($params, [true])
            && count($rule_param_format) === count($params);

        if (!$params_type_validation) {
            throw new ValidationParamsException(rule: $rule, params: $params);
        }

        for ($i = 0; $i < count($params); $i++) {

            foreach ($rule_param_format[$i] as $param_validation_rule => $param_validation_params) {
                $param_to_validate = $params[$i];
                $param_validation = Validator::$param_validation_rule(
                    $param_to_validate,
                    [$param_validation_params]
                );

                if (!$param_validation) {
                    throw new ValidationParamsException(rule: $rule, params: $params);
                }
            }

        }
    }

    private static function normalizeParams(mixed &$params, array $rule_param_format): void {
        if (count($rule_param_format) === 1) {
            $params = [$params];
        }
    }
}
