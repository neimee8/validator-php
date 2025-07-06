<?php

namespace Neimee8\ValidatorPhp\Enums;

enum LogicMode: string {
    case AND = 'AND';
    case OR = 'OR';
    case NOT = 'NOT';
    case XOR = 'XOR';
}
