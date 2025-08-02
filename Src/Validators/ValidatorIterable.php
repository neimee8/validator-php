<?php

declare(strict_types = 1);

namespace Neimee8\ValidatorPhp\Validators;

use \Traversable;

use Neimee8\ValidatorPhp\Validators\Helpers\ValidatorHelper;

final class ValidatorIterable {
    use ValidatorHelper;

    private static function it_array(iterable $value, array $params): bool {
        return is_array($value);
    }

    private static function it_traversable(iterable $value, array $params): bool {
        return is_object($value) && $value instanceof Traversable;
    }
}
