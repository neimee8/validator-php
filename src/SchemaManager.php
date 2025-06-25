<?php

namespace Neimee8\ValidatorPhp;

use \FilesystemIterator;

use Neimee8\ValidatorPhp\Exceptions\ValidationRuleGroupException;
use Neimee8\ValidatorPhp\Exceptions\ValidationSchemaFileException;

class SchemaManager {
    use StaticConfig;

    private static array $schema_cache = [
        'resolved' => [],
        'unresolved' => []
    ];

    private static function getDataFromSchemaFile(
        string $schema,
        bool $assoc = true,
        $resolve_variables = true
    ): array {
        self::initConfig();

        // checks if there is requested schema
        $allowed_schemas = [];

        foreach (new FilesystemIterator(__DIR__ . '/../' . self::$cnf -> SCHEMAS_DIR) as $file) {
            if ($file -> isFile()) {
                $allowed_schemas[] = substr($file -> getFilename(), 0, -strlen('_schema.json'));
            }
        }

        $loadSchema = function (string $schema_name) use ($allowed_schemas, $assoc): array {
            if (isset(self::$schema_cache['unresolved'][$schema_name])) {
                return self::$schema_cache['unresolved'][$schema_name];
            }

            // if schema does not exists
            if (!in_array($schema_name, $allowed_schemas, strict: true)) {
                throw new ValidationSchemaFileException(schema_file: $schema_name);
            }

            $data = json_decode(
                file_get_contents(
                    __DIR__ . '/../' . self::$cnf -> SCHEMAS_DIR . $schema_name . '_schema.json'
                ),
                $assoc
            );

            self::$schema_cache['unresolved'][$schema_name] = $data;

            return $data;
        };

        $data = $loadSchema($schema);

        if (!$resolve_variables) {
            return $data;
        }

        if (isset(self::$schema_cache['resolved'][$schema])) {
            return self::$schema_cache['resolved'][$schema];
        }

        // resolving variables
        $resolveVariable = function (string $variable) use ($loadSchema): mixed {
            $data_source = [
                'type' => null,
                'identifier' => null
            ];

            $keys = [];

            $exploded = explode('>', $variable);

            $given_source = explode(':', $exploded[0]);
            $data_source['type'] = $given_source[0];

            if (count($given_source) > 1) {
                $data_source['identifier'] = $given_source[1];
            }

            if (count($exploded) > 1) {
                $keys = explode('.', $exploded[1]);
            }

            if ($data_source['type'] === 'schema' && $data_source['identifier'] !== null) {
                $data = $loadSchema($data_source['identifier']);

                foreach ($keys as $key) {
                    if (is_array($data) && array_key_exists($key, $data)) {
                        $data = $data[$key];
                    } else {
                        return "%$variable% [NOT VALID]";
                    }
                }

                return $data;
            }

            return "%$variable% [NOT VALID]";
        };

        $recursiveWalker = function (mixed &$schema_segment) use (&$recursiveWalker, $resolveVariable): void {
            foreach ($schema_segment as &$value) {
                if (is_array($value)) {
                    $recursiveWalker($value);
                } elseif (is_string($value)) {
                    $value = preg_replace_callback(
                        pattern: '/%(.+?)%/',
                        callback: function ($matches) use ($resolveVariable): string {
                            $resolved = $resolveVariable($matches[1]);

                            if (is_scalar($resolved)) {
                                return (string) $resolved;
                            }

                            return json_encode($resolveVariable($matches[1]));
                        },
                        subject: $value
                    );

                    $decoded = json_decode($value, true);
                    $value = json_last_error() === JSON_ERROR_NONE ? $decoded : $value;
                }
            }
        };

        $recursiveWalker($data);

        self::$schema_cache['resolved'][$schema] = $data;

        return $data;
    }

    public static function getRuleSchema(): array {
        return self::getDataFromSchemaFile('validation_rules', resolve_variables: false);
    }

    public static function getListOfGroups(): array {
        return array_keys(self::getDataFromSchemaFile('validation_rules', resolve_variables: false));
    }

    public static function getListOfRules(): array {
        $schema = self::getDataFromSchemaFile('validation_rules', resolve_variables: false);
        $list = [];

        foreach (array_values($schema) as $rules) {
            $list = array_merge($list, array_keys($rules));
        }

        return $list;
    }

    public static function getRuleParamFormat(): array {
        $schema = self::getDataFromSchemaFile('validation_rules', resolve_variables: false);
        $rule_param_format = [];

        foreach (array_values($schema) as $rules) {
            foreach ($rules as $rule => $format) {
                $rule_param_format[$rule] = $format['params'];
            }
        }

        return $rule_param_format;
    }

    public static function getRuleParamFormatByGroup(string $rule_group): array {
        $schema = self::getDataFromSchemaFile('validation_rules', resolve_variables: false);
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
        $schema = self::getDataFromSchemaFile('validation_rules', resolve_variables: false);
        $groups = [];

        foreach ($schema as $group => $rules) {
            foreach (array_keys($rules) as $rule_name) {
                $groups[$rule_name] = $group;
            }
        }

        return $groups;
    }

    public static function getDataTypes(): array {
        $schema = self::getDataFromSchemaFile('data_types', resolve_variables: false);

        return $schema['all'];
    }

    public static function getGroupsOfTypes(): array {
        $schema = self::getDataFromSchemaFile('data_types', resolve_variables: false);
        $groups = [];

        foreach ($schema['by_group'] as $group => $types) {
            foreach ($types as $type) {
                $groups[$type] = $group;
            }
        }

        return $groups;
    }

    public static function getTypesOfGroup(string $rule_group, bool $nullable = true): array {
        $schema = self::getDataFromSchemaFile('data_types', resolve_variables: false);
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
        $schema = self::getDataFromSchemaFile('validators', resolve_variables: false);

        return $schema;
    }
}
