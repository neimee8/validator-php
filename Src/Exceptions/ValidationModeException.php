<?php

declare(strict_types = 1);

namespace Neimee8\ValidatorPhp\Exceptions;

use Neimee8\ValidatorPhp\Enums\ValidationMode;

final class ValidationModeException extends ValidationException {
    public function __construct(
        string $message = '',
        int $code = self::CODE_INVALID_VALIDATION_MODE,
        mixed $validation_mode = null
    ) {
        $this -> exception = 'ValidationModeException';

        $this -> validation_mode = $validation_mode;
        $this -> code = $code;

        $this -> message = $message !== '' ? 'Additional message: ' . $message . '. ' : '';

        if ($validation_mode !== null) {
            $this -> message .= 'Invalid validation mode: ';

            if ($validation_mode instanceof ValidationMode) {
                $this -> message .= $validation_mode -> name;
            } else {
                $this -> message .= json_encode($validation_mode, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            }

            $this -> message .= '. ';
        }

        $modes = ValidationMode::cases();
        $last_index = count($modes) - 1;
        $modes_string = '';

        foreach ($modes as $i => $validation_mode) {
            $modes_string .= $validation_mode -> name;

            if ($i < $last_index - 1) {
                $modes_string .= ', ';
            } elseif ($i === $last_index - 1) {
                $modes_string .= ' or ';
            }
        }

        $this -> message .= "Validation mode must be one of: $modes_string, defined as class constants.";

        parent::__construct(
            $this -> message,
            $this -> code,
            validation_mode: $this -> validation_mode
        );
    }
}
