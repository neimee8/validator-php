<?php

declare(strict_types = 1);

namespace Neimee8\ValidatorPhp\Input\Normalizers;

use Neimee8\ValidatorPhp\Schemas\SchemaManager;
use Neimee8\ValidatorPhp\Templates\NodeTemplate;

final class NodeNormalizer {
    use NormalizerHelper;

    public static function normalizeNode(mixed $node): mixed {
        if (!is_array($node)) {
            return $node;
        }

        $normalized = self::normalizeIndexedArrayToAssociative(
            given_array: $node,
            allowed_keys: array_keys(NodeTemplate::getEmpty()),
            initial_template: NodeTemplate::getEmpty()
        );

        $normalized['params'] = self::normalizeParams(
            $normalized['params'],
            $normalized['rule']
        );

        return $normalized;
    }

    public static function normalizeParams(mixed $params, mixed $rule): mixed {
        if ($params === []) {
            return [];
        }

        if (
            !is_array($params)
            || !is_string($rule)
        ) {
            return $params;
        }

        $param_metadata = SchemaManager::getSpecificRuleParamMetadata($rule);

        if ($param_metadata === null) {
            return $params;
        }

        $normalized = self::normalizeIndexedArrayToAssociative(
            given_array: $params,
            allowed_keys: array_keys($param_metadata)
        );

        return $normalized;
    }
}
