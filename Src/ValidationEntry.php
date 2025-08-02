<?php

declare(strict_types = 1);

namespace Neimee8\ValidatorPhp;

use \Closure;

use Neimee8\ValidatorPhp\Enums\ValidationMode;
use Neimee8\ValidatorPhp\Enums\EmptyMarker;

use Neimee8\ValidatorPhp\Templates\EntryTemplate;
use Neimee8\ValidatorPhp\Templates\ReportTemplate;

use Neimee8\ValidatorPhp\Input\Normalizers\EntryNormalizer;
use Neimee8\ValidatorPhp\Input\Validators\EntryValidator;
use Neimee8\ValidatorPhp\Input\Normalizers\OperandNormalizer;
use Neimee8\ValidatorPhp\Input\Validators\OperandValidator;
use Neimee8\ValidatorPhp\Processors\EntryProcessor;

use Neimee8\ValidatorPhp\Exceptions\ValidationException;

final class ValidationEntry extends ValidationAgent {
    private array $entry;

    protected function init(): void {
        $this -> entry = EntryTemplate::getEmpty();

        static::$empty_report = ReportTemplate::getEmpty('entry');
        static::$raw_retrieve_exception = fn() => new ValidationException(
            message: 'The entry contains unprocessed or unvalidated values. '
                . 'To retrieve them anyway, set allow_raw = true'
        );

        parent::init();
    }

    public function __construct(
        array|self|null $entry = null,
        mixed $value = EmptyMarker::VALUE,
        array|ValidationNode|ValidationExpression|null $operand = null,
        ?ValidationMode $validation_mode = null
    ) {
        $this -> init();

        if ($validation_mode !== null) {
            $this -> setValidationMode($validation_mode);
        }

        if (is_array($entry)) {
            $this -> setEntry($entry);
        } elseif ($entry instanceof self) {
            $this -> fromObject($entry);
        }

        if ($value !== EmptyMarker::VALUE) {
            $this -> setValue($value);
        }

        if ($operand !== null) {
            $this -> setOperand($operand);
        }
    }

    public function __clone() {
        $this -> entry['operand'] = clone $this -> entry['operand'];
    }

    public function setEntry(array $entry): void {
        $entry = EntryNormalizer::normalizeEntry(
            $entry,
            $this -> validation_mode
        );

        EntryValidator::validateEntry($entry);

        $this -> entry = $entry;
        $this -> ready = true;
    }

    public function getEntry($allow_raw = false): array {
        return $this -> handleRetrieve(
            $allow_raw,
            function(): array {
                $entry_to_retrieve = $this -> entry;
                $entry_to_retrieve['operand'] = $this -> getOperand(true);

                return $entry_to_retrieve;
            }
        );
    }

    public function clearEntry(): void {
        $this -> entry = EntryTemplate::getEmpty();
        $this -> ready = false;
    }

    public function setValue(mixed $value): void {
        EntryValidator::validateValue($value);

        $this -> entry['value'] = $value;

        if ($this -> entry['operand'] !== EntryTemplate::getEmpty()['operand']) {
            $this -> ready = true;
        }
    }

    public function getValue($allow_raw = false): mixed {
        return $this -> handleRetrieve(
            $allow_raw,
            fn() => $this -> entry['value']
        );
    }

    public function clearValue(): void {
        $this -> entry['value'] = EntryTemplate::getEmpty()['value'];
        $this -> ready = false;
    }

    public function setOperand(array|ValidationNode|ValidationExpression $operand): void {
        $operand = OperandNormalizer::normalizeOperand(
            $operand,
            $this -> validation_mode
        );

        OperandValidator::validateOperand($operand);

        $this -> entry['operand'] = $operand;

        if ($this -> entry['operand'] !== EntryTemplate::getEmpty()['operand']) {
            $this -> ready = true;
        }
    }

    public function getOperand($allow_raw = false): ValidationNode|ValidationExpression|null {
        return $this -> handleRetrieve(
            $allow_raw,
            function() {
                return $this -> entry['operand'] !== null
                    ? clone $this -> entry['operand']
                    : null;
            }
        );
    }

    public function useOperand(Closure $handler): void {
        if ($this -> entry['operand'] === EntryTemplate::getEmpty()['operand']) {
            throw new ValidationException('operand is empty');
        }

        $operand = $this -> entry['operand'];
        $handler = $handler -> bindTo(null, null);

        $handler($operand);

        if ($operand -> isEmpty()) {
            $this -> clearOperand();
        }
    }

    public function clearOperand(): void {
        $this -> entry['operand'] = EntryTemplate::getEmpty()['operand'];
        $this -> ready = false;
    }

    public function isEmpty(): bool {
        return EntryTemplate::isEmpty($this -> entry);
    }

    public function validate(
        bool $force_validation_mode = true,
        bool $collect_detailed = true,
        bool $return_report = false
    ): bool|array {
        $this -> clearReport();

        if ($this -> isEmpty()) {
            throw new ValidationException('Entry is empty');
        }

        if (!$this -> isReady()) {
            EntryValidator::validateEntry($this -> entry);
        }

        $processed = EntryProcessor::process(
            $this -> entry['value'],
            $this -> entry['operand'],
            $this -> validation_mode,
            $force_validation_mode,
            $collect_detailed
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
        array|self $entry,
        ?ValidationMode $validation_mode = null,
        bool $force_validation_mode = true,
        bool $collect_detailed = true,
        bool $return_report = false
    ): bool|array {
        $instance = $entry instanceof self
            ? $entry
            : new self(
                entry: $entry,
                validation_mode: $validation_mode
            );

        return $instance -> validate(
            $force_validation_mode,
            $collect_detailed,
            $return_report
        );
    }
}
