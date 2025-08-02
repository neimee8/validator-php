<?php

declare(strict_types = 1);

namespace Neimee8\ValidatorPhp\Input\Normalizers;

use Neimee8\ValidatorPhp\Enums\ValidationMode;

use Neimee8\ValidatorPhp\ValidationNode;
use Neimee8\ValidatorPhp\ValidationExpression;
use Neimee8\ValidatorPhp\Schemas\SchemaManager;

use Neimee8\ValidatorPhp\Exceptions\ValidationException;

final class OperandNormalizer {
    public static function normalizeOperand(
        mixed $operand,
        ValidationMode $validation_mode
    ): mixed {
        if (
            $operand instanceof ValidationNode
            || $operand instanceof ValidationExpression
            || !is_array($operand)
            || $operand === []
        ) {
            return $operand;
        }

        try {
            if (array_key_exists('logic', $operand)) {
                return new ValidationExpression(
                    expression: $operand,
                    validation_mode: $validation_mode
                );
            }

            if (array_key_exists('rule', $operand)) {
                return new ValidationNode(
                    node: $operand,
                    validation_mode: $validation_mode
                );
            }

            if (array_key_exists(0, $operand)) {
                $allowed_logic_modes = SchemaManager::getLogicModes();
                $first = $operand[0];

                return in_array($first, $allowed_logic_modes, strict: true)
                    ? new ValidationExpression(
                        expression: $operand,
                        validation_mode: $validation_mode
                    )
                    : new ValidationNode(
                        node: $operand,
                        validation_mode: $validation_mode
                    );
            }
        } catch (ValidationException) {}

        return $operand;
    }
}
