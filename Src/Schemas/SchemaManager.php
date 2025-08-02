<?php

declare(strict_types = 1);

namespace Neimee8\ValidatorPhp\Schemas;

use \FilesystemIterator;

use Neimee8\ValidatorPhp\Cache;

final class SchemaManager {
    private const SCHEMAS_DIR = 'Src/Schemas/SchemaFiles/';
    private static array $cache = [];

    private static function withCache(callable $callback): mixed {
        $backtrace = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 2)[1];
        $method = $backtrace['function'];
        $args = $backtrace['args'];

        $selector = [$method, $args];

        $cache_response = Cache::get(
            storage: self::$cache,
            selector_segments: $selector
        );

        if (!Cache::isEmpty($cache_response)) {
            return $cache_response;
        }

        $response = $callback();

        Cache::set(
            storage: self::$cache,
            selector_segments: $selector,
            value: $response
        );

        return $response;
    }
    
    private static function getDataFromSchemaFile(string $schema): ?array {
        return self::withCache(function() use ($schema) {
            // checks if there is requested schema
            $schemas_dir = __DIR__ . '/../../' . self::SCHEMAS_DIR;
            $allowed_schemas = [];

            foreach (new FilesystemIterator($schemas_dir) as $file) {
                if ($file -> isFile()) {
                    $allowed_schemas[] = substr($file -> getFilename(), 0, -strlen('Schema.php'));
                }
            }

            // if schema does not exists
            if (!in_array($schema, $allowed_schemas, strict: true)) {
                return null;
            }

            $path = $schemas_dir . $schema . 'Schema.php';
            $response = require $path;

            return $response;
        });
    }

    // returns default values for unrequired parameters of rules in specific rule group
    // structure:
    //     <rule> => [
    //         <param> => <default_value>
    //         ...
    //     ]
    //     ...
    public static function getDefaultParamValuesInRuleGroup(mixed $rule_group): ?array {
        return self::withCache(function() use ($rule_group) {
            $param_metadata = self::getParamMetadataByRuleGroup($rule_group);

            if ($param_metadata === null) {
                return null;
            }

            $response = [];

            foreach ($param_metadata as $rule => $params) {
                foreach ($params as $param => $metadata) {
                    if (!$metadata['required']) {
                        $response[$rule][$param] = $metadata['default'];
                    }
                }
            }

            return $response;
        });
    }

    public static function getListOfRulesByRuleGroup(mixed $rule_group): ?array {
        return self::withCache(function() use ($rule_group) {
            $schema = self::getDataFromSchemaFile('ValidationRules');
            $rules = null;

            if (is_string($rule_group)) {
                $rules = $schema[$rule_group] ?? null;
            } else {
                return null;
            }

            if ($rules === null) {
                return null;
            }

            return array_keys($rules);
        });
    }

    public static function getParamMetadataByRuleGroup(mixed $rule_group): ?array {
        return self::withCache(function() use ($rule_group) {
            $schema = self::getDataFromSchemaFile('ValidationRules');
            $rules = null;

            if (is_string($rule_group)) {
                $rules = $schema[$rule_group] ?? null;
            } else {
                return null;
            }

            if ($rules === null) {
                return null;
            }

            $response = [];

            foreach ($rules as $rule => $rule_metadata) {
                $response[$rule] = $rule_metadata['params'];
                $response[$rule] += SchemaManager::getDataFromSchemaFile('CommonParams');
            }

            return $response;
        });
    }

    public static function getAllParamMetadata(): array {
        return self::withCache(function() {
            $rule_groups = self::getListOfRuleGroups();
            $response = [];

            foreach ($rule_groups as $rule_group) {
                $response = array_merge($response, self::getParamMetadataByRuleGroup($rule_group));
            }

            return $response;
        });
    }

    public static function getSpecificRuleParamMetadata(mixed $rule): ?array {
        return self::withCache(function() use ($rule) {
            $response = null;
    
            if (is_string($rule)) {
                $response = self::getAllParamMetadata()[$rule] ?? null;
            }

            return $response;
        });
    }

    public static function getTypesOfGroup(mixed $rule_group, bool $nullable = true): ?array {
        return self::withCache(function() use ($rule_group, $nullable) {
            $schema = self::getDataFromSchemaFile('DataTypes');
            $response = null;

            if (is_string($rule_group)) {
                $response = $schema['by_group'][$rule_group] ?? null;
            }

            if ($response === null) {
                return null;
            }

            if (!$nullable) {
                $response = array_filter(
                    $response,
                    fn($type) => !str_starts_with($type, '?')
                );
            }

            return $response;
        });
    }

    public static function getGroupsOfRules(): array {
        return self::withCache(function() {
            $schema = self::getDataFromSchemaFile('ValidationRules');
            $response = [];

            foreach ($schema as $group => $rules) {
                foreach (array_keys($rules) as $rule_name) {
                    $response[$rule_name] = $group;
                }
            }

            return $response;
        });
    }

    public static function getListOfRules(): array {
        return self::withCache(function() {
            $schema = self::getDataFromSchemaFile('ValidationRules');
            $response = [];

            foreach (array_values($schema) as $rules) {
                $response = array_merge($response, array_keys($rules));
            }

            return $response;
        });
    }

    public static function getListOfRuleGroups(): array {
        return self::withCache(function() {
            return [
                ...array_values(
                    self::getDataFromSchemaFile('PrefixRuleGroups')
                ),
                'general'
            ];
        });
    }

    public static function getRuleGroupByRule(mixed $rule): ?string {
        return self::withCache(function() use ($rule) {
            if (!is_string($rule)) {
                return null;
            }

            $prefix = explode('_', $rule)[0];

            return self::getDataFromSchemaFile('PrefixRuleGroups')[$prefix] ?? 'general';
        });
    }

    public static function getDataTypes(): array {
        return self::withCache(function() {
            $schema = self::getDataFromSchemaFile('DataTypes');

            return $schema['all'];
        });
    }

    public static function getLogicModes(): array {
        return self::withCache(function() {
            return self::getDataFromSchemaFile('LogicModes');
        });
    }
}
