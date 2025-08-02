<?php

declare(strict_types = 1);

namespace Neimee8\ValidatorPhp\Templates;

final class MapTemplate {
    public static function getEmpty(): array {
        return [];
    }

    public static function isEmpty(array $map): bool {
        return $map === self::getEmpty();
    }
}
