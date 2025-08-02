<?php

declare(strict_types = 1);

namespace Neimee8\ValidatorPhp\Input\Validators;

use Neimee8\ValidatorPhp\Templates\EntryTemplate;
use Neimee8\ValidatorPhp\Enums\EmptyMarker;

use Neimee8\ValidatorPhp\Exceptions\ValidationException;

final class EntryValidator {
    use ValidatorHelper;

    public static function validateEntry(mixed $entry): void {
        if (!is_array($entry)) {
            throw new ValidationException('entry should to be of array type');
        }

        self::validateKeys(
            given_keys: array_keys($entry),
            allowed_keys: array_keys(EntryTemplate::getEmpty()),
            exception: fn() => new ValidationException('incompatible keys')
        );

        if (count($entry) !== count(EntryTemplate::getEmpty())) {
            throw new ValidationException('entry should be length 2');
        }

        self::validateValue($entry['value']);
        OperandValidator::validateOperand($entry['operand']);
    }

    public static function validateValue(mixed $value): void {
        if ($value === EmptyMarker::VALUE) {
            throw new ValidationException('value should be set');
        }
    }
}
