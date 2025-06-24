<?php

namespace Neimee8\ValidatorPhp\Exceptions;

use Neimee8\ValidatorPhp\SchemaManager;

class ValidationParamsException extends ValidationException {
    public function __construct(
        string $message = '',
        int $code = self::CODE_INVALID_PARAMS,
        mixed $rule = null,
        mixed $params = null
    ) {
        $this -> exception = 'ValidationParamsException';

        $this -> rule = $rule;
        $this -> params = $params;
        $this -> code = $code;

        $this -> message = $message !== '' ? 'Additional message: ' . $message . '. ' : '';

        if ($params !== null) {
            $given_params_json = '';

            for ($i = 0; $i < count($this -> params); $i++) {
                $given_params_json .= json_encode($this -> params[$i], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

                if ($i < (count($this -> params) - 1)) {
                    $given_params_json .= ', ';
                }
            }

            $this -> message .= 'Invalid params: ' . $given_params_json . '.';

            if ($rule !== null) {
                $rule_format = SchemaManager::getRuleParamFormat() ?? null;

                $this -> message .= ' Params should satisfy these rules: ' . json_encode($rule_format[$rule], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . '.';
            }
        } else {
            $this -> message .= 'Missing required params.';
        }

        parent::__construct(
            $this -> message,
            $this -> code,
            rule: $this -> rule,
            params: $this -> params
        );
    }
}
