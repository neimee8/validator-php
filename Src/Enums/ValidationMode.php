<?php

declare(strict_types = 1);

namespace Neimee8\ValidatorPhp\Enums;

enum ValidationMode {
    case DISALLOW_INCOMPATIBLE_VALUES;
    case ALLOW_INCOMPATIBLE_VALUES;
}
