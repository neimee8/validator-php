<?php

namespace Neimee8\ValidatorPhp;

use Neimee8\ValidatorPhp\Enums\LogicMode;
use Neimee8\ValidatorPhp\Enums\ValidationMode;

use Neimee8\ValidatorPhp\Exceptions\ValidationException;
use Neimee8\ValidatorPhp\Exceptions\ValidationRuleException;
use Neimee8\ValidatorPhp\Exceptions\ValidationModeException;
use Neimee8\ValidatorPhp\Exceptions\ValidationRulePathException;
use Neimee8\ValidatorPhp\Exceptions\ValidationLogicModeException;
use Neimee8\ValidatorPhp\Exceptions\ValidationRuleNodeException;

class ValidationRules {
    public const THROW_EXCEPTION = ValidationMode::THROW_EXCEPTION;
    public const SILENT = ValidationMode::SILENT;

    public const AND = LogicMode::AND;
    public const OR = LogicMode::OR;
    public const NOT = LogicMode::NOT;
    public const XOR = LogicMode::XOR;

    private static LogicMode $default_logic_mode = self::AND;

    private array $pseudo_rules_str_array;
    private array $allowed_default_logic_modes = [
        self::AND,
        self::OR
    ];

    private array $rules = [];
    private array $result = [
        'result' => null,
        'options' => [],
        'report' => []
    ];

    public function __construct(?array $rules = null) {
        $this -> pseudo_rules_str_array = array_map(
            fn ($mode) => $mode -> name,
            LogicMode::cases()
        );

        if ($rules !== null) {
            $this -> addRules($rules);
        }
    }

    public function addRules(array $rules): void {
        $rules_type_validation = 
            Validator::arr_min_len($rules, 1)
            && Validator::arr_is_indexed($rules, true);

        if (!$rules_type_validation) {
            throw new ValidationRuleException(
                message: 'rules should be an indexed array, where the elements are the arrays (rule nodes)'
            );
        }

        foreach ($rules as $key => $value) {
            $this->rules[$key] = $value;
        }
    }

    public function clearRules(): void {
        $this -> rules = [];
    }

    public function clearNode(string|array $path): bool {
        self::preparePath($path);

        if (!$this -> nodeExists($path)) {
            return false;
        }

        $node = &$this -> rules;
        $last_index = array_pop($path);

        foreach ($path as $segment) {
            if (Validator::str_int($segment, true)) {
                $segment = (int) $segment;
            }

            $node = &$node[$segment];
        }

        unset($node[$last_index]);

        return true;
    }

    public function getRules(): array {
        return $this -> rules;
    }

    public function getNode(string|array $path): ?array {
        self::preparePath($path);

        if (!$this -> nodeExists($path)) {
            return null;
        }

        $node = $this -> rules;
        $last_index = array_pop($path);

        foreach ($path as $segment) {
            if (Validator::str_int($segment, true)) {
                $segment = (int) $segment;
            }

            $node = $node[$segment];
        }

        return $node[$last_index];
    }

    public function getFullResult(): array {
        return $this -> result;
    }

    public function getResult(): ?bool {
        return $this -> result['result'];
    }

    public function getOptions(): array {
        return $this -> result['options'];
    }

    public function getReport(): array {
        return $this -> result['report'];
    }

    public function nodeExists(string|array $path): bool {
        self::preparePath($path);

        $node = $this -> rules;

        foreach ($path as $segment) {
            if (!Validator::types($segment, ['string', 'int'])) {
                throw new ValidationRulePathException(rule_path: $path);
            }

            if (Validator::str_int($segment, true)) {
                $segment = (int) $segment;
            }

            if (
                Validator::type($node, 'array')
                && Validator::arr_contains_key($node, $segment)
            ) {
                $node = $node[$segment];
            } else {
                return false;
            }
        }

        return true;
    }

    private static function preparePath(string|array &$path) {
        if (
            Validator::type($path, 'array')
            && (
                !Validator::arr_is_indexed($path, true)
                || !Validator::arr_min_len($path, 1)
            )
        ) {
            throw new ValidationRulePathException(rule_path: $path);
        }

        if (Validator::type($path, 'string')) {
            $path = explode('.', $path);
        }
    }

    public function validate(
        mixed $value,
        ValidationMode $validation_mode = self::THROW_EXCEPTION,
        ?LogicMode $default_logic_mode = null
    ): array {
        if (Validator::value_not_in($validation_mode, ValidationMode::cases())) {
            throw new ValidationModeException(validation_mode: $validation_mode);
        }

        if ($default_logic_mode === null) {
            $default_logic_mode = self::$default_logic_mode;
        }

        if (
            Validator::value_not_in(
                $default_logic_mode,
                $this -> allowed_default_logic_modes
            )
        ) {
            throw new ValidationLogicModeException(
                message: 'only ' . implode(', ', $this -> allowed_default_logic_modes) . ' are allowed as default logic modes',
                logic_mode: $default_logic_mode
            );
        }

        $this -> result = [
            'result' => null,
            'options' => [
                'validation_mode' => $validation_mode -> name,
                'default_logic_mode' => $default_logic_mode -> name
            ],
            'report' => []
        ];

        self::$default_logic_mode = $default_logic_mode;

        if ($this -> rules === []) {
            return $this -> result;
        }

        $this -> result['result'] = self::handleRules(
            $this -> rules,
            $value,
            $validation_mode,
            $default_logic_mode
        );

        return $this -> result;
    }

    public static function quickValidate(
        mixed $value,
        array $rules,
        ValidationMode $validation_mode = self::THROW_EXCEPTION,
        ?LogicMode $default_logic_mode = null
    ): array {
        $instance = new self($rules);

        if ($default_logic_mode === null) {
            $default_logic_mode = self::$default_logic_mode;
        }

        return $instance -> validate(
            $value,
            $validation_mode,
            $default_logic_mode
        );
    }

    private function handleRules(
        array $nodes,
        mixed $value,
        ValidationMode $validation_mode,
        LogicMode $parent_logic_mode,
        array $path = []
    ): bool {
        $logic_mode_validation = Validator::value_in(
            $parent_logic_mode,
            LogicMode::cases()
        );

        if (!$logic_mode_validation) {
            $this -> result['result'] = false;

            throw new ValidationLogicModeException(logic_mode: $parent_logic_mode);
        }

        $nodes_validation = 
            Validator::arr_is_indexed($nodes, true)
            && Validator::arr_min_len($nodes, 1);

        if (!$nodes_validation) {
            $this -> result['result'] = false;

            throw new ValidationRuleNodeException(
                message: 'nodes should be a non empty indexed array',
                rule_node: $nodes
            );
        }

        $result = null;

        foreach ($nodes as $i => $node) {
            $node_validation = 
                Validator::arr_is_assoc($node, true)
                && Validator::arr_len($node, 1);

            if (!$node_validation) {
                $this -> result['result'] = false;

                throw new ValidationRuleNodeException();
            }

            $current_path = [...$path, $i];

            $is_pseudo_rule = Validator::value_in(
                array_keys($node)[0],
                $this -> pseudo_rules_str_array
            );

            $intermediate_result = null;

            if ($is_pseudo_rule) {
                $recursive_nodes = array_values($node)[0];
                $recursive_logic_mode = LogicMode::from(array_keys($node)[0]);
                $recursive_path = [...$current_path, $recursive_logic_mode -> name];

                if (
                    $recursive_logic_mode === self::XOR
                    && !Validator::arr_max_len($recursive_nodes, 2)
                ) {
                    $this -> result['result'] = false;

                    throw new ValidationRuleNodeException(message: 'XOR rule block should contain 1 or 2 rule nodes');
                }

                $intermediate_result = self::handleRules(
                    $recursive_nodes,
                    $value,
                    $validation_mode,
                    $recursive_logic_mode,
                    $recursive_path
                );
            } else {
                $rule = array_keys($node)[0];
                $params = array_values($node)[0];

                $rule_path = [...$current_path, $rule];
                $rule_path_str = implode('.', $rule_path);

                $report = [
                    'path' => $rule_path,
                    'path_str' => $rule_path_str,
                    'rule' => $rule,
                    'params' => $params,
                    'value' => $value
                ];

                try {
                    $intermediate_result = Validator::$rule($value, $params);

                    $report = [
                        ...$report,
                        'result' => $intermediate_result,
                        'exception' => null
                    ];
                } catch (ValidationException $e) {
                    $report = [
                        ...$report,
                        'result' => false,
                        'exception' => $e
                    ];

                    $this -> result['report'][] = $report;

                    if ($validation_mode === ValidationMode::THROW_EXCEPTION) {
                        $this -> result['result'] = false;

                        throw $e;
                    } elseif ($validation_mode === ValidationMode::SILENT) {
                        $intermediate_result = false;
                    }
                }

                $this -> result['report'][] = $report;
            }

            $logic_mode = match ($parent_logic_mode) {
                self::NOT => self::$default_logic_mode,
                default => $parent_logic_mode
            };

            if ($result === null) {
                $result = $intermediate_result;
            } else {
                switch ($logic_mode) {
                    case self::AND:
                        $result = $result && $intermediate_result;
                        break;
                    case self::OR:
                        $result = $result || $intermediate_result;
                        break;
                    case self::XOR:
                        $result = 
                            (!$result && $intermediate_result)
                            || ($result && !$intermediate_result);
                        break;
                }
            }
        }

        if ($parent_logic_mode === self::NOT) {
            $result = !$result;
        }

        return $result;
    }
}
