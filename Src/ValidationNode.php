<?php

declare(strict_types = 1);

namespace Neimee8\ValidatorPhp;

use Neimee8\ValidatorPhp\Enums\ValidationMode;
use Neimee8\ValidatorPhp\Templates\NodeTemplate;
use Neimee8\ValidatorPhp\Templates\ReportTemplate;

use Neimee8\ValidatorPhp\Input\Validators\NodeValidator;

use Neimee8\ValidatorPhp\Input\Normalizers\NodeNormalizer;

use Neimee8\ValidatorPhp\Processors\NodeProcessor;

use Neimee8\ValidatorPhp\Exceptions\ValidationException;
use Neimee8\ValidatorPhp\Exceptions\ValidationNodeException;

final class ValidationNode extends ValidationAgent {
    private array $node;

    protected function init(): void {
        $this -> node = NodeTemplate::getEmpty();

        static::$empty_report = ReportTemplate::getEmpty('node');
        static::$raw_retrieve_exception = fn() => new ValidationException(
            message: 'The expression contains unprocessed or unvalidated values. '
                . 'To retrieve them anyway, set allow_raw = true'
        );

        parent::init();
    }

    public function __construct(
        array|self|null $node = null,
        ?string $rule = null,
        ?array $params = null,
        ?ValidationMode $validation_mode = null
    ) {
        $this -> init();

        if ($validation_mode !== null) {
            $this -> setValidationMode($validation_mode);
        }

        if (is_array($node)) {
            $this -> setNode($node);
        } elseif ($node instanceof self) {
            $this -> fromObject($node);
        }

        if ($rule !== null) {
            $this -> setRule($rule);
        }

        if ($params !== null) {
            $this -> setParams($params);
        }
    }

    public function setNode(array $node): void {
        $node = NodeNormalizer::normalizeNode($node);
        NodeValidator::validateNode($node);

        $this -> node = $node;
        $this -> ready = true;
    }

    public function getNode(bool $allow_raw = false): array {
        return $this -> handleRetrieve(
            $allow_raw,
            fn(): array => $this -> node
        );
    }

    public function clearNode(): void {
        $this -> node = NodeTemplate::getEmpty();
        $this -> ready = false;
    }

    public function setRule(string $rule): void {
        NodeValidator::validateRule($rule);
        
        $this -> node['rule'] = $rule;
        $this -> ready = false;

        $this -> clearParams();

        try {
            $params = NodeNormalizer::normalizeParams(
                $this -> node['params'],
                $rule
            );

            NodeValidator::validateParams($params, $rule);

            $this -> node['params'] = $params;
            $this -> ready = true;
        } catch (ValidationException) {}
    }

    public function getRule(bool $allow_raw = false): ?string {
        return $this -> handleRetrieve(
            $allow_raw,
            fn(): ?string => $this -> node['rule']
        );
    }

    public function setParams(array $params = []): void {
        if ($this -> node['rule'] === NodeTemplate::getEmpty()['rule']) {
            throw new ValidationNodeException('Cannot set parameters before a rule has been defined');
        }

        $params = NodeNormalizer::normalizeParams(
            $params,
            $this -> node['rule']
        );

        NodeValidator::validateParams($params, $this -> node['rule']);

        $this -> node['params'] = $params;
        $this -> ready = true;
    }

    public function getParams(bool $allow_raw = false): array {
        return $this -> handleRetrieve(
            $allow_raw,
            fn(): array => $this -> node['params']
        );
    }

    public function clearParams(): void {
        $this -> node['params'] = NodeTemplate::getEmpty()['params'];
        $this -> ready = false;
    }

    public function isEmpty(): bool {
        return NodeTemplate::isEmpty($this -> node);
    }

    public function validate(
        mixed $value,
        bool $return_report = false
    ): bool|array {
        $this -> clearReport();

        if ($this -> isEmpty()) {
            throw new ValidationNodeException('Node is empty. Set node before validation');
        }

        if (!$this -> isReady()) {
            NodeValidator::validateNode($this -> node);
        }

        $processed = NodeProcessor::process(
            $value,
            $this -> node['rule'],
            $this -> node['params'],
            $this -> validation_mode
        );

        $this -> report = $processed['report'];

        if ($processed['exception'] !== null) {
            throw $processed['exception'];
        }

        return $return_report
            ? $this -> getReport()
            : $this -> getResult();
    }

    public static function quickValidate(
        mixed $value,
        array|self $node,
        ?ValidationMode $validation_mode = null,
        bool $return_report = false
    ): bool|array {
        $instance = $node instanceof self
            ? $node
            : new self(
                node: $node,
                validation_mode: $validation_mode
            );

        return $instance -> validate($value, $return_report);
    }
}
