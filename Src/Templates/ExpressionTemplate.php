<?php

declare(strict_types = 1);

namespace Neimee8\ValidatorPhp\Templates;

final class ExpressionTemplate {
    public static function getEmpty(): array {
        $empty = [
            'logic' => null,
            'operands' => [],
            'invert' => false
        ];

        return $empty;
    }

    public static function isEmpty(array $expression): bool {
        return $expression['logic'] === self::getEmpty()['logic']
            && $expression['operands'] === self::getEmpty()['operands'];
    }
}
