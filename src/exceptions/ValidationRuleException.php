<?php

namespace Libs\Server\Validation\Exceptions;

use Libs\Server\Validation\SchemaManager;

class ValidationRuleException extends ValidationException {
    public function __construct(
        string $message = '',
        int $code = self::CODE_INVALID_RULE,
        mixed $rule = null,
    ) {
        $this -> exception = 'ValidationRuleException';

        $this -> rule = $rule;
        $this -> code = $code;

        $this -> message = $message !== '' ? 'Additional message: ' . $message . '. ' : '';

        if ($rule !== null) {
            $this -> message .= 'Invalid rule: ' . $this -> rule . '. ';
        } else {
            $this -> message .= 'Required tules should be set. ';
        }

        $this -> message .= 'List of required rules: ' . implode(', ', SchemaManager::getListOfRequiredRules()) . '. ';
        $this -> message .= 'List of valid rules: ' . implode(', ', SchemaManager::getListOfRules()) . '.';

        parent::__construct(
            $this -> message,
            $this -> code,
            rule: $this -> rule
        );
    }
}
