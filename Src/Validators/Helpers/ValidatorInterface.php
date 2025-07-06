<?php

namespace Neimee8\ValidatorPhp\Validators\Helpers;

interface ValidatorInterface {
    public static function validate(string $rule, mixed $value, mixed $params): bool;
}
