<?php

namespace Neimee8\ValidatorPhp;

use Neimee8\ValidatorPhp\Enums\ValidationMode;
use Neimee8\ValidatorPhp\Exceptions\ValidationException;
use Neimee8\ValidatorPhp\Exceptions\ValidationRuleException;
use Neimee8\ValidatorPhp\Exceptions\ValidationModeException;

class ValidationRules {
    public const THROW_EXCEPTION = ValidationMode::THROW_EXCEPTION;
    public const SILENT = ValidationMode::SILENT;

    private array $rules = [];
    private array $result = [
        'result' => null,
        'report' => []
    ];

    public function __construct(?array $rules = null) {
        if ($rules !== null) {
            $this -> addRules($rules);
        }
    }

    public function addRules(array $rules): void {
        $rules_type_validation = Validator::arr_min_len($rules, 1);

        if ($rules_type_validation) {
            $rules_type_validation = $rules_type_validation && Validator::arr_is_assoc($rules, true);
        }

        if (!$rules_type_validation) {
            throw new ValidationRuleException(
                message: 'rules should be an associative array where the keys are rule names and the values are their params'
            );
        }

        $this -> rules = array_merge($this -> rules, $rules);
    }

    public function clearRule(string $rule): void {
        if ($this -> ruleExists($rule)) {
            unset($this -> rules[$rule]);
        }
    }

    public function clearRules(): void {
        $this -> rules = [];
    }

    public function getRules(): array {
        return $this -> rules;
    }

    public function getRuleParams(string $rule): mixed {
        if ($this -> ruleExists($rule)) {
            return $this -> rules[$rule];
        } else {
            return null;
        }
    }

    public function getFullResult(): array {
        return $this -> result;
    }

    public function getResult(): ?bool {
        return $this -> result['result'];
    }

    public function getReport(): array {
        return $this -> result['report'];
    }

    public function ruleExists(string $rule): bool {
        return array_key_exists($rule, $this -> rules);
    }

    public function validate(
        mixed $value,
        ValidationMode $mode = self::THROW_EXCEPTION
    ): array {
        if (Validator::value_not_in($mode, ValidationMode::cases())) {
            throw new ValidationModeException(mode: $mode);
        }

        $this -> result = [
            'result' => null,
            'report' => []
        ];

        if ($this -> rules === []) {
            return $this -> result;
        }

        foreach ($this -> rules as $rule => $params) {
            $validation_result = true;

            if ($mode === self::SILENT) {
                try {
                    $validation_result = Validator::$rule($value, $params);
                } catch (ValidationException $e) {
                    $this -> result['result'] = false;
                    $this -> result['report'][$rule] = $e;

                    continue;
                }
            } elseif ($mode === self::THROW_EXCEPTION) {
                try {
                    $validation_result = Validator::$rule($value, $params);
                } catch (ValidationException $e) {
                    $this -> result['result'] = false;

                    throw $e;
                }
            }

            if (!$validation_result) {
                $this -> result['result'] = false;
            }

            $this -> result['report'][$rule] = $validation_result;
        }

        if ($this -> result['result'] === null) {
            $this -> result['result'] = true;
        }

        return $this -> result;
    }

    public static function quickValidate(
        mixed $value,
        array $rules,
        ValidationMode $mode = self::THROW_EXCEPTION
    ): array {
        $instance = new self($rules);

        return $instance -> validate($value, $mode);
    }
}
