<?php

namespace Neimee8\ValidatorPhp\Exceptions;

use Neimee8\ValidatorPhp\StaticConfig;

class ValidationSchemaFileException extends ValidationException {
    public function __construct(
        string $message = '',
        int $code = self::CODE_SCHEMA_FILE_NOT_FOUND,
        mixed $schema_file = null,
        ?array $allowed_schemas = null
    ) {
        $this -> exception = 'ValidationSchemaFileException';

        $this -> schema_file = $schema_file . '_schema.php';
        $this -> code = $code;

        $this -> message = $message !== '' ? 'Additional message: ' . $message . '. ' : '';
        $this -> message .= 'Schema file not found: ';

        if ($schema_file !== null && is_scalar($schema_file)) {
            $this -> message .= (string) $schema_file;
        } else {
            $this -> message .= '[schema file].';
        }

        if ($allowed_schemas !== null) {
            $this -> message .= ' List of valid schemas: ' . implode(', ', $allowed_schemas) . '.';
        }

        parent::__construct(
            $this -> message,
            $this -> code,
            schema_file: $this -> schema_file
        );
    }
}
