<?php

declare(strict_types = 1);

namespace Neimee8\ValidatorPhp\Input\Validators;

use Neimee8\ValidatorPhp\ValidationNode;
use Neimee8\ValidatorPhp\ValidationExpression;

use Neimee8\ValidatorPhp\Exceptions\ValidationException;

final class OperandValidator {
    public static function validateOperand(mixed $operand): void {
        if (
            !($operand instanceof ValidationNode)
            && !($operand instanceof ValidationExpression)
            && !is_array($operand)
        ) {
            throw new ValidationException('operand should be array or instance of ValidationExpression or ValidationNode');
        }

        if (
            (
                ($operand instanceof ValidationNode
                || $operand instanceof ValidationExpression)
                && $operand -> isEmpty()
            )
            || (
                is_array($operand)
                && count($operand) === 0
            )
        ) {
            throw new ValidationException('Operand is empty');
        }

        if (
            $operand instanceof ValidationNode
            || $operand instanceof ValidationExpression
        ) {
            return;
        }

        if (array_key_exists('logic', $operand)) {
            ExpressionValidator::validateExpression($operand);
        }

        if (array_key_exists('rule', $operand)) {
            NodeValidator::validateNode($operand);
        }

        throw new ValidationException('operand should be array or instance of ValidationExpression or ValidationNode');
    }
}
