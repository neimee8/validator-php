<?php

declare(strict_types = 1);

namespace Neimee8\ValidatorPhp;

use \Closure;

use Neimee8\ValidatorPhp\Enums\ValidationMode;
use Neimee8\ValidatorPhp\Templates\ExpressionTemplate;
use Neimee8\ValidatorPhp\Templates\ReportTemplate;

use Neimee8\ValidatorPhp\Input\Validators\ExpressionValidator;
use Neimee8\ValidatorPhp\Input\Normalizers\ExpressionNormalizer;
use Neimee8\ValidatorPhp\Processors\ExpressionProcessor;

use Neimee8\ValidatorPhp\Exceptions\ValidationException;

final class ValidationExpression extends ValidationAgent {
    private array $expression;

    protected function init(): void {
        $this -> expression = ExpressionTemplate::getEmpty();

        static::$empty_report = ReportTemplate::getEmpty('expression');
        static::$raw_retrieve_exception = fn() => new ValidationException(
            message: 'The expression contains unprocessed or unvalidated values. '
                . 'To retrieve them anyway, set allow_raw = true'
        );

        parent::init();
    }

    public function __construct(
        array|self|null $expression = null,
        string $logic = 'all',
        ?array $operands = null,
        ?bool $invert = null,
        ?ValidationMode $validation_mode = null
    ) {
        $this -> init();

        if ($validation_mode !== null) {
            $this -> setValidationMode($validation_mode);
        }

        if (is_array($expression)) {
            $this -> setExpression($expression);
        } elseif ($expression instanceof self) {
            $this -> fromObject($expression);
        }

        $this -> setLogic($logic);

        if ($operands !== null) {
            $this -> setOperands($expression);
        }

        if ($invert !== null) {
            $this -> setInvertion($invert);
        }
    }

    public function __clone() {
        for ($i = 0; $i < count($this -> expression['operands']); $i++) {
            $this -> expression['operands'][$i] = clone $this -> expression['operands'][$i];
        }
    }

    public function setExpression(array $expression): void {
        $expression = ExpressionNormalizer::normalizeExpression(
            $expression,
            $this -> validation_mode
        );

        ExpressionValidator::validateExpression($expression);

        $this -> expression = $expression;
        $this -> ready = true;
    }

    public function getExpression(bool $allow_raw = false): array {
        return $this -> handleRetrieve(
            $allow_raw,
            function(): array {
                $expression_to_retrieve = $this -> expression;
                $expression_to_retrieve['operands'] = $this -> getOperands(true);

                return $expression_to_retrieve;
            }
        );
    }

    public function clearExpression(): void {
        $this -> expression = ExpressionTemplate::getEmpty();
        $this -> ready = false;
    }

    public function setLogic(string $logic): void {
        ExpressionValidator::validateLogic($logic);

        $this -> expression['logic'] = $logic;

        if ($this -> expression['operands'] !== ExpressionTemplate::getEmpty()['operands']) {
            $this -> ready = true;
        }
    }

    public function getLogic(bool $allow_raw = false): ?string {
        return $this -> handleRetrieve(
            $allow_raw,
            fn(): ?string => $this -> expression['logic']
        );
    }

    public function clearLogic(): void {
        $this -> expression['logic'] = ExpressionTemplate::getEmpty()['logic'];
        $this -> ready = false;
    }

    public function setOperands(array $operands): void {
        $operands = ExpressionNormalizer::normalizeOperands(
            $operands,
            $this -> validation_mode
        );

        ExpressionValidator::validateOperands($operands);

        if ($this -> expression['logic'] !== ExpressionTemplate::getEmpty()['logic']) {
            $this -> ready = true;
        }
    }

    public function getOperands(bool $allow_raw = false): array {
        return $this -> handleRetrieve(
            $allow_raw,
            function(): array {
                $operands_to_retrieve = [];

                foreach ($this -> expression['operands'] as $operand) {
                    $operands_to_retrieve[] = clone $operand;
                }

                return $operands_to_retrieve;
            }
        );
    }

    private function &getOperandsRef(): array {
        return $this -> expression['operands'];
    }

    public function addOperands(array $operands): void {
        $operands = ExpressionNormalizer::normalizeOperands(
            $operands,
            $this -> validation_mode
        );

        ExpressionValidator::validateOperands($operands);

        $this -> expression['operands'] = [
            ...$this -> expression['operands'],
            ...$operands
        ];

        if ($this -> expression['logic'] !== ExpressionTemplate::getEmpty()['logic']) {
            $this -> ready = true;
        }
    }

    public function clearOperands(): void {
        $this -> expression['operands'] = ExpressionTemplate::getEmpty()['operands'];
        $this -> ready = false;
    }

    private function reindexOperands(int $break_point = 0): void {
        if ($break_point >= count($this -> expression['operands'])) {
            return;
        }

        $this -> expression['operands'] = array_values($this -> expression['operands']);
    }

    public function getOperand(string $path): ValidationExpression|ValidationNode {
        $operand = $this -> getOperandRef($path);

        if ($operand === self::$null_ref) {
            throw new ValidationException('Operand not found');
        }

        return clone $operand;
    }

    private function &getOperandRef(string $path): ValidationExpression|ValidationNode|null {
        $path_segments = explode('/', $path);
        $operand = null;

        if (array_key_exists($path_segments[0], $this -> expression['operands'])) {
            $operand = &$this -> expression['operands'][$path_segments[0]];
        } else {
            return self::$null_ref;
        }

        foreach ($path_segments as $i => $path_segment) {
            if ($i === 0) {
                continue;
            }

            $operands = [];

            if ($operand instanceof ValidationExpression) {
                $operands = &$operand -> getOperandsRef();
            } else {
                return self::$null_ref;
            }

            if (array_key_exists($path_segment, $operands)) {
                $operand = &$operands[$path_segment];
            } else {
                return self::$null_ref;
            }
        }

        return $operand;
    }

    private function &getOperandParentRef(string $path): ValidationExpression|null {
        $path = explode('/', $path);
        array_pop($path);

        $parent_path = implode('/', $path);

        $parent = $parent_path === ''
            ? $this
            : $this -> getOperandRef($parent_path);

        if (
            $parent === self::$null_ref
            || $parent instanceof ValidationNode
        ) {
            return self::$null_ref;
        }

        return $parent;
    }

    public function addOperand(
        ValidationExpression|ValidationNode|array $operand
    ): void {
        $wrapped_operand = ExpressionNormalizer::normalizeOperands(
            [$operand],
            $this -> validation_mode
        );

        ExpressionValidator::validateOperands($wrapped_operand);

        $this -> expression['operands'][] = $wrapped_operand[0];

        if ($this -> expression['logic'] !== ExpressionTemplate::getEmpty()['logic']) {
            $this -> ready = true;
        }
    }

    public function replaceOperand(
        string $path,
        ValidationExpression|ValidationNode|array $operand
    ): void {
        $wrapped_operand = ExpressionNormalizer::normalizeOperands(
            [$operand],
            $this -> validation_mode
        );

        ExpressionValidator::validateOperands($wrapped_operand);

        $replacable = &$this -> getOperandRef($path);

        if ($replacable === self::$null_ref) {
            throw new ValidationException('Operand not found');
        }

        $replacable = $wrapped_operand[0];
    }

    public function useOperand(
        string $path,
        Closure $handler
    ): void {
        $parent = $this -> getOperandParentRef($path);
        $operand_index = array_pop(explode('/', $path));

        if ($parent === self::$null_ref) {
            throw new ValidationException('Operand not found');
        }

        $operand = $parent -> getOperandRef($operand_index);

        if ($operand === self::$null_ref) {
            throw new ValidationException('Operand not found');
        }

        $handler = $handler -> bindTo(null, null);

        $handler($operand);

        if ($operand -> isEmpty()) {
            $parent -> clearOperand($operand_index);
        }
    }

    public function clearOperand(string $path): void {
        $parent = $this -> getOperandParentRef($path);
        $operand_index = array_pop(explode('/', $path));

        if (
            $parent === self::$null_ref
            || $parent instanceof ValidationNode
        ) {
            throw new ValidationException('Operand not found');
        }

        $operands = &$parent -> getOperandsRef();

        if (!array_key_exists($operand_index, $operands)) {
            throw new ValidationException('Operand not found');
        }

        unset($operands[$operand_index]);

        if (count($operands) === 0) {
            $parent -> ready = false;
        } else {
            $parent -> reindexOperands((int) $operand_index);
        }
    }

    public function operandExists(string $path): bool {
        return $this -> getOperandRef($path) !== self::$null_ref;
    }

    public function setInvertion(bool $invert = true): void {
        $this -> expression['invert'] = $invert;
    }

    public function isInverted(): bool {
        return $this -> expression['invert'];
    }

    public function getOperandResult(string $path): bool {
        foreach ($this -> report['detailed'] as $section) {
            if (array_key_exists($path, $section)) {
                return $section[$path]['result'];
            }
        }

        throw new ValidationException('Operand result not found');
    }

    public function getOperandReport(string $path): array {
        foreach ($this -> report['detailed'] as $section) {
            if (array_key_exists($path, $section)) {
                return $section[$path];
            }
        }

        throw new ValidationException('Operand report not found');
    }

    public function resetHard(): void {
        parent::resetHard();

        $this -> expression['invert'] = false;
    }

    public function isEmpty(): bool {
        return ExpressionTemplate::isEmpty($this -> expression);
    }

    public function validate(
        mixed $value,
        bool $force_validation_mode = true,
        bool $collect_detailed = true,
        bool $return_report = false
    ): bool|array {
        $this -> clearReport();

        if ($this -> isEmpty()) {
            throw new ValidationException('Expression is empty');
        }

        if (!$this -> isReady()) {
            ExpressionValidator::validateExpression($this -> expression);
        }

        $processed = ExpressionProcessor::process(
            $value,
            $this -> expression['logic'],
            $this -> expression['operands'],
            $this -> expression['invert'],
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
        mixed $value,
        array|self $expression,
        ?ValidationMode $validation_mode = null,
        bool $force_validation_mode = true,
        bool $collect_detailed = true,
        bool $return_report = false
    ): bool|array {
        $instance = $expression instanceof self
            ? $expression
            : new self(
                expression: $expression,
                validation_mode: $validation_mode
            );

        return $instance -> validate(
            $value,
            $force_validation_mode,
            $collect_detailed,
            $return_report
        );
    }
}
