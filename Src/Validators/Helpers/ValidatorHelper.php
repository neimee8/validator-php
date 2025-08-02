<?php

declare(strict_types = 1);

namespace Neimee8\ValidatorPhp\Validators\Helpers;

use Neimee8\ValidatorPhp\Schemas\SchemaManager;
use Neimee8\ValidatorPhp\Input\Validators\NodeValidator;
use Neimee8\ValidatorPhp\Input\Validators\ValueValidator;

trait ValidatorHelper {
    private static string $rule_group;
    private static array $default_values;

    public static function validate(
        string $rule,
        mixed $value,
        array $params = []
    ): bool {
        self::prepareVars($rule);

        ValidationContext::enter();

        try {
            if (ValidationContext::isExternalCall()) {
                NodeValidator::validateRule($rule, self::$rule_group);
                NodeValidator::validateParams($params, $rule, self::$rule_group);

                ValueValidator::validateValue($value, $rule, self::$rule_group);
            }

            $params = self::prepareParams($rule, $params);

            return self::applyCommonParams(
                expression: self::$rule($value, $params),
                params: $params
            );
        } finally {
            ValidationContext::exit();
        }
    }

    private static function prepareVars(string $rule): void {
        self::$rule_group = SchemaManager::getRuleGroupByRule($rule);
        self::$default_values = SchemaManager::getDefaultParamValuesInRuleGroup(self::$rule_group);
    }

    private static function prepareParams(string $rule, array $params): array {
        foreach (self::$default_values[$rule] as $param => $default_value) {
            if (!array_key_exists($param, $params)) {
                $params[$param] = $default_value;
            }
        }

        return $params;
    }

    private static function applyCommonParams(bool $expression, array $params): bool {
        $expression = $params['invert'] ? !$expression : $expression;

        return $expression;
    }
}
