<?php

declare(strict_types = 1);

namespace Neimee8\ValidatorPhp\Validators;

use Neimee8\ValidatorPhp\Exceptions\ValidationException;
use Neimee8\ValidatorPhp\Schemas\SchemaManager;

use Neimee8\ValidatorPhp\Exceptions\ValidationValueException;

final class Delegator {
    private const VALIDATORS_NAMESPACE = '\\Neimee8\\ValidatorPhp\\Validators\\';

    public static function __callStatic(string $rule, array $args): bool {
        // checks for existence of value
        if (!array_key_exists(0, $args)) {
            throw new ValidationValueException(message: 'Value should be set');
        }

        if (count($args) > 2) {
            throw new ValidationException(
                message: 'Unexpected parameters: '
                    . json_encode(array_slice($args, 2), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
            );
        }

        $value = $args[0];
        $params = $args[1] ?? [];

        $rule_group = SchemaManager::getRuleGroupByRule($rule);

        $validator = self::VALIDATORS_NAMESPACE
            . 'Validator'
            . ucfirst($rule_group);

        return $validator::validate($rule, $value, $params);
    }
}
