<?php

declare(strict_types = 1);

namespace Neimee8\ValidatorPhp\Input\Validators;

use Neimee8\ValidatorPhp\ValidationEntry;

use Neimee8\ValidatorPhp\Exceptions\ValidationException;

final class MapValidator {
    public static function validateMap(mixed $map): void {
        if (!is_array($map)) {
            throw new ValidationException('map should be of array type');
        }

        if (count($map) === 0) {
            throw new ValidationException('map is empty');
        }

        foreach ($map as $entry) {
            if (!($entry instanceof ValidationEntry)) {
                throw new ValidationException('map should contain only valid validation entries');
            }
        }
    }
}
