<?php

declare(strict_types = 1);

namespace Neimee8\ValidatorPhp\Exceptions;

final class ValidationNodeException extends ValidationException {
    public function __construct(
        string $message = '',
        int $code = self::CODE_INVALID_NODE,
        mixed $node = null
    ) {
        $this -> exception = 'ValidationNodeException';

        $this -> node = $node;
        $this -> code = $code;

        $this -> message = $message !== '' ? 'Additional message: ' . $message . '. ' : '';

        if ($node !== null) {
            $this -> message .= 'Invalid node: ' . json_encode($node, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . '. ';
            $this -> message .= 'Each node must be 1-2 element array, where the first element is a rule name (with key \'rule\' or 0) and the second element is its parameters wrapped into array (with key \'params\' or 1).';
        }

        parent::__construct(
            $this -> message,
            $this -> code,
            node: $this -> node
        );
    }
}
