<?php

namespace Libs\Server\Validation;

use Libs\Server\Validation\Config;

trait StaticConfig {
    private static Config $cnf;

    private static function initConfig(): void {
        self::$cnf = new Config;
    }
}
