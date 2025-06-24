<?php

namespace Libs\Server\Validation;

class Config {
    public readonly string $SCHEMAS_DIR;
    public readonly string $VALIDATORS_NAMESPACE;

    public function __construct() {
        $this -> SCHEMAS_DIR = 'libs/server/validation/schemas/';
        $this -> VALIDATORS_NAMESPACE = '\\Libs\\Server\\Validation\\Validators\\';
    }
}
