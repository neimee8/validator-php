<?php

namespace Neimee8\ValidatorPhp\Exceptions;

class ValidationRulePathException extends ValidationException {
    public function __construct(
        string $message = '',
        int $code = self::CODE_INVALID_RULE_PATH,
        mixed $rule_path = null
    ) {
        $this -> exception = 'ValidationRulePathException';

        $this -> rule_path = $rule_path;
        $this -> code = $code;

        $this -> message = $message !== '' ? 'Additional message: ' . $message . '. ' : '';

        if ($rule_path !== null) {
            $this -> message .= 'Invalid rule path: ' . json_encode($rule_path, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . '. ';
        }

        $this -> message .= 'The rule path must be either a dot-separated string (e.g., "0.AND.foo") or a non-empty indexed array of segments. Each segment must be a string or integer';

        parent::__construct(
            $this -> message,
            $this -> code,
            rule_path: $this -> rule_path
        );
    }
}
