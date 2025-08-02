<?php

declare(strict_types = 1);

namespace Neimee8\ValidatorPhp\Templates;

use Neimee8\ValidatorPhp\Enums\EmptyMarker;

final class EntryTemplate {
    public static function getEmpty(): array {
        $empty = [
            'value' => EmptyMarker::VALUE,
            'operand' => null
        ];

        return $empty;
    }

    public static function isEmpty(array $entry): bool {
        return $entry === self::getEmpty();
    }
}
