<?php

declare(strict_types = 1);

namespace Neimee8\ValidatorPhp\Exceptions;

use Neimee8\ValidatorPhp\Enums\ValidationMapType;

final class ValidationMapTypeException extends ValidationException {
    public function __construct(
        string $message = '',
        int $code = self::CODE_INVALID_MAP_TYPE,
        mixed $map_type = null
    ) {
        $this -> exception = 'ValidationMapTypeException';

        $this -> map_type = $map_type;
        $this -> code = $code;

        $this -> message = $message !== '' ? 'Additional message: ' . $message . '. ' : '';

        if ($map_type !== null) {
            $this -> message .= 'Invalid map type: ';

            if ($map_type instanceof ValidationMapType) {
                $this -> message .= $map_type -> name;
            } else {
                $this -> message .= json_encode($map_type, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            }

            $this -> message .= '. ';
        }

        $map_types = ValidationMapType::cases();
        $last_index = count($map_types) - 1;
        $map_types_string = '';

        foreach ($map_types as $i => $map_type) {
            $map_types_string .= $map_type -> name;

            if ($i < $last_index - 1) {
                $map_types_string .= ', ';
            } elseif ($i === $last_index - 1) {
                $map_types_string .= ' or ';
            }
        }

        $this -> message .= "Map type must be one of: $map_types_string, defined as class constants.";

        parent::__construct(
            $this -> message,
            $this -> code,
            map_type: $this -> map_type
        );
    }
}
