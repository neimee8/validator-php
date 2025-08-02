<?php

declare(strict_types = 1);

namespace Neimee8\ValidatorPhp\Enums;

enum MethodType {
    case STATIC;
    case NOT_STATIC;
    case ALL;
}
