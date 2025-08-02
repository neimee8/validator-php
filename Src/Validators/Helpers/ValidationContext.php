<?php

declare(strict_types = 1);

namespace Neimee8\ValidatorPhp\Validators\Helpers;

final class ValidationContext {
    private static int $counter = 0;

    public static function enter(): void {
        self::$counter++;
    }

    public static function exit(): void {
        self::$counter--;
    }

    public static function isExternalCall(): bool {
        return self::$counter < 2;
    }
}
