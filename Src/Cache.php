<?php

declare(strict_types = 1);

namespace Neimee8\ValidatorPhp;

use Neimee8\ValidatorPhp\Enums\EmptyMarker;

final class Cache {
    private static function selector_hash(array $selector_segments): string {
        return hash('sha256', serialize($selector_segments));
    }

    public static function set(
        array &$storage,
        array $selector_segments,
        mixed $value
    ): void {
        $selector_hash = self::selector_hash($selector_segments);
        $storage[$selector_hash] = $value;
    }

    public static function get(
        array &$storage,
        array $selector_segments
    ): mixed {
        $selector_hash = self::selector_hash($selector_segments);

        if (!array_key_exists($selector_hash, $storage)) {
            return EmptyMarker::CACHE;
        }

        return $storage[$selector_hash];
    }

    public static function isEmpty(mixed &$cache_response): bool {
        return $cache_response === EmptyMarker::CACHE;
    }
}
