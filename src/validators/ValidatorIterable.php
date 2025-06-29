<?php

namespace Neimee8\ValidatorPhp\Validators;

use \Traversable;

use Neimee8\ValidatorPhp\Validators\Helpers\ValidationInvoker;

class ValidatorIterable {
    use ValidationInvoker;

    private static function iterable_is_array(iterable $value, array $params): bool {
        $must_be = $params[0]; // true or false

        return $must_be === is_array($value);
    }

    private static function iterable_is_traversable(iterable $value, array $params): bool {
        $must_be = $params[0]; // true or false

        return $must_be === (is_object($value) && $value instanceof Traversable);
    }
}
