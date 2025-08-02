<?php

declare(strict_types = 1);

namespace Neimee8\ValidatorPhp\Validators;

use Neimee8\ValidatorPhp\Validators\Helpers\ValidatorHelper;

final class ValidatorResource {
    use ValidatorHelper;

    private static function res_types($value, array $params): bool {
        foreach ($params['types'] as $type) {
            if (get_resource_type($value) === $type) {
                return true;
            }
        }

        return false;
    }

    private static function res_type($value, array $params): bool {
        return self::validate(
            rule: 'res_types',
            value: $value,
            params: ['types' => [$params['type']]]
        );
    }
}
