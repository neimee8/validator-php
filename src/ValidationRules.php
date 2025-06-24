<?php

namespace Neimee8\ValidatorPhp;

use Neimee8\ValidatorPhp\Exceptions\ValidationException;
use Neimee8\ValidatorPhp\Exceptions\ValidationRuleException;
use Neimee8\ValidatorPhp\Exceptions\ValidationModeException;

class ValidationRules {
    public const THROW_EXCEPTION = 1 << 0;
    public const SILENT = 1 << 1;

    private array $rules;
    private array $result = [
        'result' => null,
        'report' => null
    ];

    public function __construct(array $rules) {
        $rules_type_validation = Validator::arr_is_assoc($rules, true);

        if (!$rules_type_validation) {
            throw new ValidationRuleException(
                message: 'rules should be an associative array where the keys are rule names and the values are their params'
            );
        }

        // сhecking that all required rules are set
        $given_rule_names = array_keys($rules);
        $required_rules = SchemaManager::getListOfRequiredRules();
        $required_rules_validation = Validator::arr_is_superset($given_rule_names, $required_rules);

        if (!$required_rules_validation) {
            throw new ValidationRuleException();
        }

        $this -> rules = $rules;
    }

    public function validate(mixed $value, int $mode = self::THROW_EXCEPTION): array {
        if (!Validator::value_in($mode, [self::THROW_EXCEPTION, self::SILENT])) {
            throw new ValidationModeException(mode: $mode);
        }

        foreach ($this -> rules as $rule => $params) {
            $validation_result = true;

            if ($mode & self::SILENT) {
                try {
                    $validation_result = Validator::$rule($value, $params);
                } catch (ValidationException $e) {
                    $this -> result['result'] = false;
                    $this -> result['report'][$rule] = $e;

                    continue;
                }
            } elseif ($mode & self::THROW_EXCEPTION) {
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

        return $this -> result;
    }

    public function validateStatic(mixed $value, array $rules, int $mode = self::THROW_EXCEPTION): array {
        $instance = new self($rules);

        return $instance -> validate($value, $mode);
    }
}
