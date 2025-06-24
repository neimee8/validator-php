<?php

namespace Libs\Server\Validation\Validators;

use Libs\Server\Validation\SchemaManager;

class ValidatorGeneral {
    use ValidationInvoker;

    private static function types(mixed $value, array $params): bool {
        $given_types = $params[0]; // array with data types or classes

        if (in_array('mixed', $given_types, strict: true)) {
            return true;
        }

        $unique_types = [];

        foreach ($given_types as $type) {
            if (str_starts_with($type, '?')) {
                $unique_types[] = 'null';
                $unique_types[] = substr($type, 1);
            } else {
                $unique_types[] = $type;
            }
        }

        $unique_types = array_unique($unique_types);
        $value_types = [];

        if (is_int($value)) {
            $value_types[] = 'int';
        } 
        
        if (is_float($value)) {
            $value_types[] = 'float';
        } 
        
        if (is_string($value)) {
            $value_types[] = 'string';
        } 
        
        if (is_bool($value)) {
            $value_types[] = 'bool';
        } 
        
        if (is_array($value)) {
            $value_types[] = 'array';
        } 
        
        if (is_callable($value)) {
            $value_types[] = 'callable';
        } 
        
        if (is_object($value)) {
            $value_types[] = 'object';
        } 
        
        if (is_resource($value)) {
            $value_types[] = 'resource';
        } 
        
        if (is_iterable($value)) {
            $value_types[] = 'iterable';
        } 
        
        if ($value === null) {
            $value_types[] = 'null';
        }

        if (in_array('string', $value_types, strict: true)) {
            set_error_handler(function() {}, E_WARNING);
            $regex_check = @preg_match($value, '');
            restore_error_handler();

            if ($regex_check !== false) {
                $value_types[] = 'regex';
            }
        }

        if (count(array_intersect($value_types, $unique_types)) > 0) {
            return true;
        }

        foreach ($unique_types as $type) {
            if (class_exists($type) && $value instanceof $type) {
                return true;
            }
        }

        return false;
    }

    private static function value_in(mixed $value, array $params): bool {
        $haystack = $params[0]; // array

        return in_array($value, $haystack, strict: true);
    }

    private static function value_not_in(mixed $value, array $params): bool {
        return !self::value_in($value, $params);
    }
}
