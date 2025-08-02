<?php

declare(strict_types = 1);

namespace Neimee8\ValidatorPhp\Processors;

use Neimee8\ValidatorPhp\Enums\ValidationMode;
use Neimee8\ValidatorPhp\Templates\ReportTemplate;

use Neimee8\ValidatorPhp\ValidationExpression;
use Neimee8\ValidatorPhp\ValidationNode;

use Neimee8\ValidatorPhp\Exceptions\ValidationException;

final class ExpressionProcessor {
    use ProcessorHelper;

    public static function process(
        mixed $value,
        string $logic,
        array $operands,
        bool $invert,
        ValidationMode $validation_mode,
        bool $force_validation_mode,
        bool $collect_detailed
    ): array {
        $processed = self::$PROCESSED_TEMPLATE;
        $processed['report'] = ReportTemplate::getEmpty('expression');

        $logic_processor = new LogicProcessor($logic, $invert);

        foreach ($operands as $i => $operand) {
            $original_mode = null;

            if ($force_validation_mode) {
                $original_mode = $operand -> getValidationMode();
                $operand -> setValidationMode($validation_mode);
            }

            try {
                $result = null;

                if ($operand instanceof ValidationExpression) {
                    $result = $operand -> validate(
                        $value,
                        $force_validation_mode,
                        $collect_detailed
                    );
                } elseif ($operand instanceof ValidationNode) {
                    $result = $operand -> validate($value);
                }

                if ($collect_detailed) {
                    self::collectDetailedReport(
                        storage: $processed['report']['detailed'],
                        key: (string) $i,
                        operand: $operand,
                        parent_logic: $logic,
                        force_validation_mode: $force_validation_mode
                    );
                }

                $logic_processor -> feed($result);
            } catch (ValidationException $e) {
                $processed['exception'] = $e;

                break;
            } finally {
                if ($original_mode !== null) {
                    $operand -> setValidationMode($original_mode);
                }
            }
        }

        self::collectReport(
            storage: $processed['report'],
            result: $processed['exception'] === null
                ? $logic_processor -> getResult()
                : null,
            logic: $logic,
            invert: $invert,
            validation_mode: $validation_mode,
            force_validation_mode: $force_validation_mode
            
        );

        return $processed;
    }

    private static function collectReport(
        array &$storage,
        bool $result,
        string $logic,
        bool $invert,
        ValidationMode $validation_mode,
        bool $force_validation_mode
    ): void {
        $storage['result'] = $result;
        $storage['logic'] = $logic;
        $storage['invert'] = $invert;
        $storage['validation_mode'] = $validation_mode;
        $storage['force_validation_mode'] = $force_validation_mode;
    }

    private static function collectDetailedReport(
        array &$storage,
        string $key,
        ValidationNode|ValidationExpression $operand,
        string $parent_logic,
        bool $force_validation_mode
    ): void {
        if ($operand instanceof ValidationExpression) {
            $storage['expressions'][$key] = ReportTemplate::getExpressionReportEmpty();
            $report = $operand -> getReport();

            foreach ($report as $param => $content) {
                if ($param !== 'detailed') {
                    $storage['expressions'][$key][$param] = $content;
                    $storage['expressions'][$key]['parent_logic'] = $parent_logic;

                    continue;
                }

                foreach ($content as $section_name => $section_content) {
                    foreach ($section_content as $path => $report_piece) {
                        $storage[$section_name]["$key/$path"] = $report_piece;
                    }
                }
            }
        } elseif ($operand instanceof ValidationNode) {
            $storage['nodes'][$key] = $operand -> getReport();

            $storage['nodes'][$key]['parent_logic'] = $parent_logic;
            $storage['nodes'][$key]['force_validation_mode'] = $force_validation_mode;
        }
    }
}
