<?php

declare(strict_types = 1);

namespace Neimee8\ValidatorPhp\Input\Validators;

use \Closure;

use Neimee8\ValidatorPhp\Schemas\SchemaManager;

trait ValidatorHelper {
    private static function getRuleGroup(mixed $rule, mixed $rule_group): string {
        if ($rule_group === null) {
            $rule_group = SchemaManager::getRuleGroupByRule($rule);
        }

        return $rule_group;
    }

    private static function validateKeys(
        array $given_keys,
        array $allowed_keys,
        Closure $exception
    ): void {
        $key_validation = count(
            array_diff($given_keys, $allowed_keys)
        ) === 0;

        if (!$key_validation) {
            throw ($exception)();
        }
    }
}
