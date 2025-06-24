<?php

namespace Libs\Server\Validation;

use \FilesystemIterator;

use Libs\Server\Validation\Exceptions\ValidationRuleGroupException;
use Libs\Server\Validation\Exceptions\ValidationSchemaFileException;

class SchemaManager {
    use StaticConfig;

    private static function getDataFromSchemaFile(string $schema, bool $assoc = true): ?array {
        self::initConfig();

        $allowed_schemas = [];

        foreach (new FilesystemIterator(self::$cnf -> SCHEMAS_DIR) as $file) {
            if ($file -> isFile()) {
                $allowed_schemas[] = substr($file -> getFilename(), 0, -strlen('_schema.json'));
            }
        }

        if (!in_array($schema, $allowed_schemas, strict: true)) {
            throw new ValidationSchemaFileException(schema_file: $schema);
        }

        $path = self::$cnf -> SCHEMAS_DIR . $schema . '_schema.json';

        return json_decode(file_get_contents($path), $assoc);
    }

    public static function getRuleSchema(): array {
        return self::getDataFromSchemaFile('validation_rules');
    }

    public static function getListOfGroups(): array {
        return array_keys(self::getDataFromSchemaFile('validation_rules'));
    }

    public static function getListOfRules(): array {
        $schema = self::getDataFromSchemaFile('validation_rules');
        $list = [];

        foreach (array_values($schema) as $rules) {
            $list = array_merge($list, array_keys($rules));
        }

        return $list;
    }

    public static function getRuleParamFormat(): array {
        $schema = self::getDataFromSchemaFile('validation_rules');
        $rule_param_format = [];

        foreach (array_values($schema) as $rules) {
            foreach ($rules as $rule => $format) {
                $rule_param_format[$rule] = $format['params'];
            }
        }

        return $rule_param_format;
    }

    public static function getRuleParamFormatByGroup(string $rule_group): ?array {
        $schema = self::getDataFromSchemaFile('validation_rules');
        $rule_param_format = [];

        foreach ($schema as $group => $rules) {
            if ($group === $rule_group) {
                foreach ($rules as $rule => $format) {
                    $rule_param_format[$rule] = $format['params'];
                }
            }
        }

        if ($rule_param_format === []) {
            throw new ValidationRuleGroupException(rule_group: $rule_group);
        }

        return $rule_param_format;
    }

    public static function getListOfRequiredRules(): array {
        $schema = self::getDataFromSchemaFile('validation_rules');
        $list = [];

        foreach (array_values($schema) as $rules) {
            foreach ($rules as $rule => $format) {
                if (isset($format['required']) && $format['required']) {
                    $list[] = $rule;
                }
            }
        }

        return $list;
    }

    public static function getGroupsOfRules(): array {
        $schema = self::getDataFromSchemaFile('validation_rules');
        $groups = [];

        foreach ($schema as $group => $rules) {
            foreach (array_keys($rules) as $rule_name) {
                $groups[$rule_name] = $group;
            }
        }

        return $groups;
    }

    public static function getDataTypes(): array {
        $schema = self::getDataFromSchemaFile('data_types');

        return $schema['all'];
    }

    public static function getGroupsOfTypes(): array {
        $schema = self::getDataFromSchemaFile('data_types');
        $groups = [];

        foreach ($schema['by_group'] as $group => $types) {
            foreach ($types as $type) {
                $groups[$type] = $group;
            }
        }

        return $groups;
    }

    public static function getTypesOfGroup(string $rule_group, bool $nullable = true): ?array {
        $schema = self::getDataFromSchemaFile('data_types');
        $types = $schema['by_group'][$rule_group] ?? null;

        if ($types === null) {
            throw new ValidationRuleGroupException(rule_group: $rule_group);
        }

        if (!$nullable) {
            $types = array_filter(
                $types,
                fn($type) => !str_starts_with($type, '?')
            );
        }

        return $types;
    }

    public static function getValidators(): array {
        $schema = self::getDataFromSchemaFile('validators');

        return $schema;
    }
}
