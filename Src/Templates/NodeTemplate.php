<?php

declare(strict_types = 1);

namespace Neimee8\ValidatorPhp\Templates;

final class NodeTemplate {
    public static function getEmpty(): ?array {
        $empty = [
            'rule' => null,
            'params' => []
        ];

        return $empty;
    }

    public static function isEmpty(array $node): bool {
        return $node === self::getEmpty();
    }
}
