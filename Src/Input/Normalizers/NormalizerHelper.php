<?php

declare(strict_types = 1);

namespace Neimee8\ValidatorPhp\Input\Normalizers;

trait NormalizerHelper {
    private static function normalizeIndexedArrayToAssociative(
        array $given_array,
        array $allowed_keys,
        array $initial_template = []
    ): array {
        $normalized = $initial_template;
        $unexpected_keys = $given_array;

        foreach ($allowed_keys as $pos => $named) {
            foreach ([$named, $pos] as $key) {
                if (array_key_exists($key, $given_array)) {
                    $normalized[$named] = $given_array[$key];
                    unset($unexpected_keys[$key]);

                    break;
                }
            }
        }

        $normalized += $unexpected_keys;

        return $normalized;
    }
}
