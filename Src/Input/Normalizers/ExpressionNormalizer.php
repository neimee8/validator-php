<?php

declare(strict_types = 1);

namespace Neimee8\ValidatorPhp\Input\Normalizers;

use Neimee8\ValidatorPhp\Templates\ExpressionTemplate;
use Neimee8\ValidatorPhp\Enums\ValidationMode;

use Neimee8\ValidatorPhp\ValidationNode;
use Neimee8\ValidatorPhp\ValidationExpression;

final class ExpressionNormalizer {
    use NormalizerHelper;

    public static function normalizeExpression(
        mixed $expression,
        ValidationMode $validation_mode
    ): mixed {
        if (!is_array($expression)) {
            return $expression;
        }

        $normalized = self::normalizeIndexedArrayToAssociative(
            given_array: $expression,
            allowed_keys: array_keys(ExpressionTemplate::getEmpty()),
            initial_template: ExpressionTemplate::getEmpty()
        );

        $normalized['operands'] = self::normalizeOperands(
            $normalized['operands'],
            $validation_mode
        );

        return $normalized;
    }

    public static function normalizeOperands(
        mixed $operands,
        ValidationMode $validation_mode
    ): mixed {
        if (
            !is_array($operands)
            || $operands === []
        ) {
            return $operands;
        }

        $normalized = [];

        foreach ($operands as $operand) {
            if (
                $operand instanceof ValidationExpression
                || $operand instanceof ValidationNode
            ) {
                if (!$operand -> isEmpty()) {
                    $normalized[] = $operand;
                }

                continue;
            }

            if ($operand === []) {
                continue;
            }

            $normalized[] = OperandNormalizer::normalizeOperand(
                $operand,
                $validation_mode
            );
        }

        return $normalized;
    }
}
