<?php

namespace Neimee8\ValidatorPhp\Exceptions;

class ValidationRuleNodeException extends ValidationException {
    public function __construct(
        string $message = '',
        int $code = self::CODE_INVALID_RULE_NODE,
        mixed $rule_node = null
    ) {
        $this -> exception = 'ValidationRuleNodeException';

        $this -> rule_node = $rule_node;
        $this -> code = $code;

        $this -> message = $message !== '' ? 'Additional message: ' . $message . '. ' : '';

        if ($rule_node !== null) {
            $this -> message .= 'Invalid rule node: ' . json_encode($rule_node, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . '. ';
        }

        $this -> message .= 'Each rule node must be a one-element associative array, where the key is a rule name or logic mode and the value is its parameters or nested rules.';

        parent::__construct(
            $this -> message,
            $this -> code,
            rule_node: $this -> rule_node
        );
    }
}
