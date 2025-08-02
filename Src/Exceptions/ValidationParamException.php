<?php

declare(strict_types = 1);

namespace Neimee8\ValidatorPhp\Exceptions;

use Neimee8\ValidatorPhp\Schemas\SchemaManager;

final class ValidationParamException extends ValidationException {
    public function __construct(
        string $message = '',
        int $code = self::CODE_INVALID_PARAMS,
        mixed $rule = null,
        mixed $params = null
    ) {
        $this -> exception = 'ValidationParamException';

        $this -> rule = $rule;
        $this -> params = $params;
        $this -> code = $code;

        $this -> message = $message !== '' ? "Additional message: " . $message . ". \n" : '';

        if ($params !== null) {
            $given_params_json = '';

            if (is_array($this -> params)) {
                foreach ($this -> params as $name => $value) {
                    $given_params_json .= (string) $name
                        . ': '
                        . json_encode($value, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

                    $given_params_json .= ", \n";
                }

                $given_params_json = substr($given_params_json, 0, -3);
            } else {
                $given_params_json = json_encode($this -> params, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            }

            $this -> message .= "Incompatible parameters: \n" . $given_params_json . ".\n";

            if ($rule !== null) {
                $this -> message .= " \n";
            }
        }
        
        if ($rule !== null) {
            $all_param_metadata = SchemaManager::getAllParamMetadata() ?? null;

            $this -> message .= 'All required parameters must be set, and all parameter count should not exceed '
            . count($all_param_metadata[$rule])
            . ". \nAlso all parameters must satisfy the following rules: \n"
            . json_encode($all_param_metadata[$rule], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . '.';
        }
        
        if ($rule === null && $params === null) {
            $this -> message .= 'Incompatible params.';
        }

        parent::__construct(
            $this -> message,
            $this -> code,
            rule: $this -> rule,
            params: $this -> params
        );
    }
}
