<?php

namespace Libs\Server\Validation\Exceptions;

use Libs\Server\Validation\SchemaManager;

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
        $this -> message .= 'Invalid rule_group: ' . $this -> rule_group;
        $this -> message .= '. List of valid groups: ' . implode(', ', SchemaManager::getListOfGroups()) . '.';

        parent::__construct(
            $this -> message,
            $this -> code,
            rule_group: $this -> rule_group
        );
    }
}
