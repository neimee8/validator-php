<?php

namespace Libs\Server\Validation\Exceptions;

use \FilesystemIterator;

use Libs\Server\Validation\StaticConfig;

class ValidationSchemaFileException extends ValidationException {
    use StaticConfig;

    public function __construct(
        string $message = '',
        int $code = self::CODE_SCHEMA_FILE_NOT_FOUND,
        mixed $schema_file = null,
    ) {
        self::initConfig();

        $this -> exception = 'ValidationSchemaFileException';

        $this -> schema_file = $schema_file . '_schema.json';
        $this -> code = $code;

        $schemas = [];

        foreach (new FilesystemIterator(self::$cnf -> SCHEMAS_DIR) as $file) {
            if ($file -> isFile()) {
                $schemas[] = substr($file -> getFilename(), 0, -strlen('_schema.json'));
            }
        }

        $this -> message = $message !== '' ? 'Additional message: ' . $message . '. ' : '';
        $this -> message .= 'Schema file not found: ';
        $this -> message .= $schema_file !== null ? $this -> schema_file : '[schema file]';
        $this -> message .= '. List of valid schemas: ' . implode(', ', $schemas) . '.';

        parent::__construct(
            $this -> message,
            $this -> code,
            schema_file: $this -> schema_file
        );
    }
}
