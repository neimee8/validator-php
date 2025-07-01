<?php

namespace Neimee8\ValidatorPhp\Exceptions;

use Neimee8\ValidatorPhp\SchemaManager;

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
            $this -> message .= 'Invalid rule: ';

            if (is_scalar($rule)) {
                $this -> message .= (string) $rule;
            } else {
                $this -> message .= json_encode($rule, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            }

            $this -> message .= '. ';
        }

        $this -> message .= 'List of valid rules: ' . implode(', ', SchemaManager::getListOfRules()) . '.';

        parent::__construct(
            $this -> message,
            $this -> code,
            rule: $this -> rule
        );
    }
}
