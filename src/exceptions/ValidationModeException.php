<?php

namespace Neimee8\ValidatorPhp\Exceptions;

use Neimee8\ValidatorPhp\Enums\ValidationMode;

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
            $this -> message .= 'Invalid mode: ' . $mode -> name . '.';
        }

        $modes = ValidationMode::cases();
        $last_index = count($modes) - 1;
        $modes_string = '';

        foreach ($modes as $i => $mode) {
            $modes_string .= $mode -> name;

            if ($i < $last_index - 1) {
                $modes_string .= ', ';
            } elseif ($i === $last_index - 1) {
                $modes_string .= ' or ';
            }
        }

        $this -> message .= "Mode must be one of: $modes_string, defined as class constants.";

        parent::__construct(
            $this -> message,
            $this -> code,
            mode: $this -> mode
        );
    }
}
