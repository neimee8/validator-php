<?php

declare(strict_types = 1);

namespace Neimee8\ValidatorPhp\Validators;

use Neimee8\ValidatorPhp\Validators\Helpers\ValidatorHelper;

final class ValidatorGeneral {
    use ValidatorHelper;

    private static function types(mixed $value, array $params): bool {
        if (in_array('mixed', $params['types'], strict: true)) {
            return true;
        }

        $unique_types = [];

        foreach ($params['types'] as $type) {
            if (str_starts_with($type, '?')) {
                $unique_types['null'] = 'null';
                $unique_types[substr($type, 1)] = substr($type, 1);
            } else {
                $unique_types[$type] = $type;
            }
        }

        $value_types = [];

        if (is_int($value)) {
            $value_types['int'] = 'int';
        } 
        
        if (is_float($value)) {
            $value_types['float'] = 'float';
        } 
        
        if (is_string($value)) {
            $value_types['string'] = 'string';
        } 
        
        if (is_bool($value)) {
            $value_types['bool'] = 'bool';
        } 
        
        if (is_array($value)) {
            $value_types['array'] = 'array';
        } 
        
        if (is_callable($value)) {
            $value_types['callable'] = 'callable';
        } 
        
        if (is_object($value)) {
            $value_types['object'] = 'object';
        } 
        
        if (is_resource($value)) {
            $value_types['resource'] = 'resource';
        } 
        
        if (is_iterable($value)) {
            $value_types['iterable'] = 'iterable';
        } 
        
        if ($value === null) {
            $value_types['null'] = 'null';
        }

        if (count(array_intersect($value_types, $unique_types)) > 0) {
            return true;
        }

        foreach ($unique_types as $type) {
            if (
                is_string($type)
                && (class_exists($type) || interface_exists($type))
                && $value instanceof $type
            ) {
                return true;
            }
        }

        return false;
    }

    private static function type(mixed $value, array $params): bool {
        return self::validate(
            rule: 'types',
            value: $value,
            params: ['types' => [$params['type']]]
        );
    }

    private static function value_in(mixed $value, array $params): bool {
        return in_array($value, $params['haystack'], $params['strict']);
    }

    private static function equals(mixed $value, array $params): bool {
        return $params['strict']
            ? $value === $params['reference']
            : $value == $params['reference'];
    }
}
