<?php

namespace Neimee8\ValidatorPhp;

use \FilesystemIterator;

use Neimee8\ValidatorPhp\Exceptions\ValidationRuleGroupException;
use Neimee8\ValidatorPhp\Exceptions\ValidationSchemaFileException;

class SchemaManager {
    private const SCHEMAS_DIR = 'src/schemas/';
    
    private static function getDataFromSchemaFile(string $schema): array {
        // checks if there is requested schema
        $schemas_dir = __DIR__ . '/../' . self::SCHEMAS_DIR;
        $allowed_schemas = [];

        foreach (new FilesystemIterator($schemas_dir) as $file) {
            if ($file -> isFile()) {
                $allowed_schemas[] = substr($file -> getFilename(), 0, -strlen('_schema.php'));
            }
        }

        // if schema does not exists
        if (!in_array($schema, $allowed_schemas, strict: true)) {
            throw new ValidationSchemaFileException(schema_file: $schema, allowed_schemas: $allowed_schemas);
        }

        $path = $schemas_dir . $schema . '_schema.php';
        $data = require $path;

        return $data;
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

    public static function getRuleParamFormatByGroup(string $rule_group): array {
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

    public static function getTypesOfGroup(string $rule_group, bool $nullable = true): array {
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
