<?php

declare(strict_types = 1);

namespace Neimee8\ValidatorPhp\Validators\Helpers;

trait ValidatorArrayHelper {
    private static function array_unique_strict(array $array, bool $strict = true): array {
        $result = [];

        foreach ($array as $el) {
            if (!in_array($el, $result, $strict)) {
                $result[] = $el;
            }
        }

        return $result;
    }
}
