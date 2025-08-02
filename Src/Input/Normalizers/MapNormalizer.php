<?php

declare(strict_types = 1);

namespace Neimee8\ValidatorPhp\Input\Normalizers;

use Neimee8\ValidatorPhp\Enums\ValidationMode;

use Neimee8\ValidatorPhp\ValidationEntry;

use Neimee8\ValidatorPhp\Exceptions\ValidationException;

final class MapNormalizer {
    public static function normalizeMap(
        mixed $map,
        ValidationMode $validation_mode
    ): mixed {
        if (!is_array($map)) {
            return $map;
        }

        $normalized = [];

        foreach ($map as $id => $entry) {
            if (
                !is_array($entry)
                && !($entry instanceof ValidationEntry)
            ) {
                $normalized[$id] = $entry;

                continue;
            }

            if (
                (
                    $entry instanceof ValidationEntry
                    && $entry -> isEmpty()
                )
                || $entry === []
            ) {
                continue;
            }

            try {
                $normalized[$id] = new ValidationEntry(
                    $entry,
                    $validation_mode
                );
            } catch (ValidationException) {
                $normalized[$id] = $entry;
            }
        }

        return $normalized;
    }
}
