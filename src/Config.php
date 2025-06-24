<?php

namespace Neimee8\ValidatorPhp;

class Config {
    public readonly string $SCHEMAS_DIR;
    public readonly string $VALIDATORS_NAMESPACE;

    public function __construct() {
        $this -> SCHEMAS_DIR = 'schemas/';
        $this -> VALIDATORS_NAMESPACE = '\\Neimee8\\ValidatorPhp\\Validators\\';
    }
}
