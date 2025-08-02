<?php

declare(strict_types = 1);

namespace Neimee8\ValidatorPhp\Input\Validators;

use Neimee8\ValidatorPhp\Schemas\SchemaManager;
use Neimee8\ValidatorPhp\Validators\Delegator;
use Neimee8\ValidatorPhp\Templates\NodeTemplate;

use Neimee8\ValidatorPhp\Exceptions\ValidationRuleException;
use Neimee8\ValidatorPhp\Exceptions\ValidationParamException;
use Neimee8\ValidatorPhp\Exceptions\ValidationNodeException;

final class NodeValidator {
    use ValidatorHelper;

    public static function validateNode(
        mixed $node,
        ?string $rule_group = null
    ): void {
        if (!is_array($node)) {
            throw new ValidationNodeException(node: $node);
        }

        self::validateKeys(
            given_keys: array_keys($node),
            allowed_keys: array_keys(NodeTemplate::getEmpty()),
            exception: fn() => new ValidationNodeException(node: $node)
        );

        if (count($node) !== count(NodeTemplate::getEmpty())) {
            throw new ValidationNodeException(node: $node);
        }

        self::validateRule($node['rule']);

        $rule_group = self::getRuleGroup(
            $node['rule'],
            $rule_group
        );

        self::validateParams(
            $node['params'],
            $node['rule'],
            $rule_group
        );
    }

    public static function validateRule(
        mixed $rule,
        ?string $rule_group = null
    ): void {
        if (!is_string($rule)) {
            throw new ValidationRuleException(rule: $rule);
        }

        $rule_group = self::getRuleGroup($rule, $rule_group);
        $allowed_rules = SchemaManager::getListOfRulesByRuleGroup($rule_group);

        if (!in_array($rule, $allowed_rules, strict: true)) {
            throw new ValidationRuleException(rule: $rule);
        }
    }

    public static function validateParams(
        mixed $params,
        string $rule,
        ?string $rule_group = null
    ): void {
        if (!is_array($params)) {
            throw new ValidationParamException(rule: $rule, params: $params);
        }

        $rule_group = self::getRuleGroup($rule, $rule_group);

        // gets param metadata for specific rule
        $param_metadata = SchemaManager::getParamMetadataByRuleGroup($rule_group);
        $rule_param_metadata = $param_metadata[$rule];

        self::validateKeys(
            given_keys: array_keys($params),
            allowed_keys: array_keys($rule_param_metadata),
            exception: fn() => new ValidationParamException(rule: $rule, params: $params)
        );
        
        $required_params = array_keys(
            array_filter(
                $rule_param_metadata,
                fn ($el) => $el['required'] === true
            )
        );

        $given_required_param_counter = 0;

        foreach ($params as $param_name => $param_value) {
            if (in_array($param_name, $required_params, strict: true)) {
                $given_required_param_counter++;
            }

            foreach ($rule_param_metadata[$param_name]['validation'] as $param_validation_node) {
                $param_validation = Delegator::{$param_validation_node['rule']}(
                    $param_value,
                    $param_validation_node['params']
                );

                if (!$param_validation) {
                    throw new ValidationParamException(rule: $rule, params: $params);
                }
            }
        }

        if ($given_required_param_counter < count($required_params)) {
            throw new ValidationParamException(rule: $rule, params: $params);
        }
    }
}
