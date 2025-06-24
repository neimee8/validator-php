<?php

namespace Neimee8\ValidatorPhp\Exceptions;

class ValidationModeException extends ValidationException {
    public function __construct(
        string $message = '',
        int $code = self::CODE_INVALID_MODE,
        mixed $mode = null
    ) {
        $this -> exception = 'ValidationModeException';

        $this -> mode = $mode;
        $this -> code = $code;

        $this -> message = $message !== '' ? 'Additional message: ' . $message . '. ' : '';

        if ($mode !== null) {
            $this -> message .= 'Invalid mode: ' . $mode. '.';
        }

        $this -> message .= 'Mode must be either THROW_EXCEPTION or SILENT, defined as class constants';

        parent::__construct(
            $this -> message,
            $this -> code,
            mode: $this -> mode
        );
    }
}
