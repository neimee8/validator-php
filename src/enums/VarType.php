<?php

namespace Neimee8\ValidatorPhp\Enums;

enum VarType: string {
    case STATIC = 'static';
    case NOT_STATIC = 'not_static';
    case ALL = 'all';
}
