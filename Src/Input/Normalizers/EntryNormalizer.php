<?php

declare(strict_types = 1);

namespace Neimee8\ValidatorPhp\Input\Normalizers;

use Neimee8\ValidatorPhp\Enums\ValidationMode;
use Neimee8\ValidatorPhp\Templates\EntryTemplate;

use Neimee8\ValidatorPhp\Schemas\SchemaManager;

use Neimee8\ValidatorPhp\ValidationNode;
use Neimee8\ValidatorPhp\ValidationExpression;

use Neimee8\ValidatorPhp\Exceptions\ValidationException;

final class EntryNormalizer {
    use NormalizerHelper;

    public static function normalizeEntry(
        mixed $entry,
        ValidationMode $validation_mode
    ): mixed {
        if (!is_array($entry)) {
            return $entry;
        }

        $normalized = self::normalizeIndexedArrayToAssociative(
            given_array: $entry,
            allowed_keys: array_keys(EntryTemplate::getEmpty()),
            initial_template: EntryTemplate::getEmpty()
        );

        $normalized['operand'] = OperandNormalizer::normalizeOperand(
            $normalized['operand'],
            $validation_mode
        );

        return $normalized;
    }
}
