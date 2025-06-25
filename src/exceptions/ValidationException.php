<?php

namespace Neimee8\ValidatorPhp\Exceptions;

use \Exception;

class ValidationException extends Exception {
    public const CODE_VALIDATION_EXCEPTION = 1000;

    public const CODE_INVALID_GROUP = 1001;
    public const CODE_INVALID_RULE = 1002;
    public const CODE_INVALID_VALUE_TYPE = 1003;
    public const CODE_INVALID_PARAMS = 1004;
    public const CODE_INVALID_MODE = 1005;
    public const CODE_INVALID_MAP_TYPE = 1006;
    public const CODE_INVALID_ENTRY = 1007;

    public const CODE_SCHEMA_FILE_NOT_FOUND = 2001;

    public mixed $rule;
    public mixed $rule_group;
    public mixed $value;
    public mixed $params;
    public mixed $schema_file;
    public mixed $mode;
    public mixed $map_type;
    public mixed $entry;

    public string $exception = 'ValidationException';

    public array $trace;

    public function __construct(
        string $message = '',
        int $code = self::CODE_VALIDATION_EXCEPTION,
        mixed $rule = null,
        mixed $rule_group = null,
        mixed $value = null,
        mixed $params = null,
        mixed $schema_file = null,
        mixed $mode = null,
        mixed $map_type = null,
        mixed $entry = null
    ) {
        $this -> rule = $rule;
        $this -> rule_group = $rule_group;
        $this -> value = $value;
        $this -> params = $params;
        $this -> schema_file = $schema_file;
        $this -> mode = $mode;
        $this -> code = $code;
        $this -> map_type = $map_type;
        $this -> entry = $entry;

        $this -> message = $message === '' ? $this -> exception : $message;

        $this -> trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);

        parent::__construct(message: $this -> message, code: $this -> code);
    }

    public function toArray() {
        $response = [];

        if ($this -> rule !== null) {
            $response['rule'] = $this -> rule;
        }

        if ($this -> rule_group !== null) {
            $response['rule_group'] = $this -> rule_group;
        }

        if ($this -> value !== null) {
            $response['value'] = $this -> value;
        }

        if ($this -> params !== null) {
            $response['params'] = $this -> params;
        }

        if ($this -> schema_file !== null) {
            $response['schema_file'] = $this -> schema_file;
        }

        if ($this -> mode !== null) {
            $response['mode'] = $this -> mode;
        }

        if ($this -> map_type !== null) {
            $response['map_type'] = $this -> map_type;
        }

        if ($this -> entry !== null) {
            $response['entry'] = $this -> entry;
        }

        $response['exception'] = $this -> exception;
        $response['code'] = $this -> code;
        $response['message'] = $this -> message;

        $response['trace'] = $this -> trace;

        return $response;
    }

    public function __toString(): string {
        $response = 'Exception: ' . $this -> exception . '. ';
        $response .= 'Code: ' . $this -> code . '. ';
        $response .= 'Message: ' . $this -> message;

        return $response;
    }
}
