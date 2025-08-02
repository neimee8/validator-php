<?php

declare(strict_types = 1);

namespace Neimee8\ValidatorPhp\Input\Validators;

use Neimee8\ValidatorPhp\Templates\ExpressionTemplate;
use Neimee8\ValidatorPhp\Schemas\SchemaManager;

use Neimee8\ValidatorPhp\Exceptions\ValidationException;

final class ExpressionValidator {
    use ValidatorHelper;

    public static function validateExpression(mixed $expression): void {
        if (!is_array($expression)) {
            throw new ValidationException('expression should to be of array type');
        }

        self::validateKeys(
            given_keys: array_keys($expression),
            allowed_keys: array_keys(ExpressionTemplate::getEmpty()),
            exception: fn() => new ValidationException('incompatible keys')
        );

        if (count($expression) !== count(ExpressionTemplate::getEmpty())) {
            throw new ValidationException('expression should be length 2');
        }

        self::validateLogic($expression['logic']);
        self::validateOperands($expression['operands']);
    }

    public static function validateLogic(mixed $logic): void {
        if (!is_string($logic)) {
            throw new ValidationException('logic mode must be a string');
        }

        $allowed_logic_modes = SchemaManager::getLogicModes();

        if (!in_array($logic, $allowed_logic_modes, strict: true)) {
            throw new ValidationException('logic mode not allowed');
        }
    }

    public static function validateOperands(mixed $operands): void {
        if (!is_array($operands)) {
            throw new ValidationException('operands should be array type');
        }

        if (count($operands) === 0) {
            throw new ValidationException('Operands are empty');
        }

        foreach ($operands as $operand) {
            OperandValidator::validateOperand($operand);
        }
    }
}
