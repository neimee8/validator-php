<?php

namespace Neimee8\ValidatorPhp\Exceptions;

use Neimee8\ValidatorPhp\SchemaManager;

class ValidationRuleGroupException extends ValidationException {
    public function __construct(
        string $message = '',
        int $code = self::CODE_INVALID_GROUP,
        mixed $rule_group = null,
    ) {
        $this -> exception = 'ValidationRuleGroupException';

        $this -> rule_group = $rule_group;
        $this -> code = $code;

        $this -> message = $message !== '' ? 'Additional message: ' . $message . '. ' : '';
        $this -> message .= 'Invalid rule_group: ';

        if ($rule_group !== null) {
            if (is_scalar($rule_group)) {
                $this -> message .= (string) $rule_group;
            } else {
                $this -> message .= json_encode($rule_group, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            }
        }

        $this -> message .= '. ';

        $this -> message .= 'List of valid groups: ' . implode(', ', SchemaManager::getListOfGroups()) . '.';

        parent::__construct(
            $this -> message,
            $this -> code,
            rule_group: $this -> rule_group
        );
    }
}
