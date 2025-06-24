<?php

namespace Neimee8\ValidatorPhp;

use Neimee8\ValidatorPhp\Config;

trait StaticConfig {
    private static Config $cnf;

    private static function initConfig(): void {
        self::$cnf = new Config;
    }
}
