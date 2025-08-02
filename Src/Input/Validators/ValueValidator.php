<?php

declare(strict_types = 1);

namespace Neimee8\ValidatorPhp\Input\Validators;

use Neimee8\ValidatorPhp\Schemas\SchemaManager;
use Neimee8\ValidatorPhp\Validators\Delegator;

use Neimee8\ValidatorPhp\Exceptions\ValidationValueException;

final class ValueValidator {
    use ValidatorHelper;

    public static function validateValue(
        mixed $value,
        string $rule,
        ?string $rule_group = null
    ): void {
        $rule_group = self::getRuleGroup($rule, $rule_group);
    
        if ($rule_group !== 'general') {
            $allowed_type_group = SchemaManager::getTypesOfGroup($rule_group, nullable: false);
            $value_validation = Delegator::types(
                $value,
                ['types' => $allowed_type_group]
            );

            if (!$value_validation) {
                throw new ValidationValueException(rule: $rule, value: $value);
            }
        }
    }
}
