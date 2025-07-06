<?php

namespace Neimee8\ValidatorPhp\Exceptions;

use Neimee8\ValidatorPhp\Enums\LogicMode;

class ValidationLogicModeException extends ValidationException {
    public function __construct(
        string $message = '',
        int $code = self::CODE_INVALID_LOGIC_MODE,
        mixed $logic_mode = null
    ) {
        $this -> exception = 'ValidationLogicModeException';

        $this -> logic_mode = $logic_mode;
        $this -> code = $code;

        $this -> message = $message !== '' ? 'Additional message: ' . $message . '. ' : '';

        if ($logic_mode !== null) {
            $this -> message .= 'Invalid mode: ';

            if ($logic_mode instanceof LogicMode) {
                $this -> message .= $logic_mode -> name;
            } else {
                $this -> message .= json_encode($logic_mode, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            }

            $this -> message .= '. ';
        }

        $modes = LogicMode::cases();
        $last_index = count($modes) - 1;
        $modes_string = '';

        foreach ($modes as $i => $logic_mode) {
            $modes_string .= $logic_mode -> name;

            if ($i < $last_index - 1) {
                $modes_string .= ', ';
            } elseif ($i === $last_index - 1) {
                $modes_string .= ' or ';
            }
        }

        $this -> message .= "Logic mode must be one of: $modes_string, defined as class constants.";

        parent::__construct(
            $this -> message,
            $this -> code,
            logic_mode: $this -> logic_mode
        );
    }
}
