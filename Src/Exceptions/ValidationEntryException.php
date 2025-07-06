<?php

namespace Neimee8\ValidatorPhp\Exceptions;

use Neimee8\ValidatorPhp\Enums\ValidationMapType;

class ValidationEntryException extends ValidationException {
    public function __construct(
        string $message = '',
        int $code = self::CODE_INVALID_ENTRY,
        mixed $entry = null
    ) {
        $this -> exception = 'ValidationEntryException';

        $this -> entry = $entry;
        $this -> code = $code;

        $this -> message = $message !== '' ? 'Additional message: ' . $message . '. ' : '';

        if ($entry !== null) {
            $this -> message .= 'Invalid entry: ' . json_encode($entry, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . '.';
        }

        $this -> message .= 'Entry should be an indexed array, where [0] => value, [1] => ValidationRules instance or rule array.';

        parent::__construct(
            $this -> message,
            $this -> code,
            entry: $this -> entry
        );
    }
}
