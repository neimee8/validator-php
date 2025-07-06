<?php

namespace Neimee8\ValidatorPhp\Exceptions;

use Neimee8\ValidatorPhp\SchemaManager;

class ValidationValueException extends ValidationException {
    public function __construct(
        string $message = '',
        int $code = self::CODE_INVALID_VALUE_TYPE,
        mixed $rule = null,
        mixed $value = null
    ) {
        $this -> exception = 'ValidationValueException';

        $this -> rule = $rule;
        $this -> value = $value;
        $this -> code = $code;

        $this -> message = $message !== '' ? 'Additional message: ' . $message . '. ' : '';

        if ($value !== null) {
            $this -> message .= 'Invalid value: ' . json_encode($this -> value, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }

        if ($rule !== null) {
            $rule_groups = SchemaManager::getGroupsOfRules();
            $rule_group = $rule_groups[$rule] ?? null;

            if ($rule_group !== null) {
                $allowed_type_group = SchemaManager::getTypesOfGroup($rule_group, nullable: false);

                $this -> message .= '. List of expected value types: ' . implode(', ', $allowed_type_group) . '.';
            }
        }

        parent::__construct(
            $this -> message,
            $this -> code,
            rule: $this -> rule,
            value: $this -> value
        );
    }
}
