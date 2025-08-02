<?php

declare(strict_types = 1);

namespace Neimee8\ValidatorPhp\Processors;

use Neimee8\ValidatorPhp\Templates\ReportTemplate;
use Neimee8\ValidatorPhp\Enums\ValidationMode;

use Neimee8\ValidatorPhp\ValidationNode;
use Neimee8\ValidatorPhp\ValidationExpression;

use Neimee8\ValidatorPhp\Exceptions\ValidationException;

final class EntryProcessor {
    use ProcessorHelper;

    public static function process(
        mixed $value,
        ValidationNode|ValidationExpression $operand,
        ValidationMode $validation_mode,
        bool $force_validation_mode,
        bool $collect_report
    ): array {
        $processed = self::$PROCESSED_TEMPLATE;
        $processed['report'] = ReportTemplate::getEmpty('entry');

        $original_mode = null;

        if ($force_validation_mode) {
            $original_mode = $operand -> getValidationMode();
            $operand -> setValidationMode($validation_mode);
        }

        try {
            if ($operand instanceof ValidationNode) {
                $operand -> validate($value);
            } elseif ($operand instanceof ValidationExpression) {
                $operand -> validate(
                    $value,
                    $force_validation_mode,
                    $collect_report
                );
            }

            $processed['report']['operand_class'] = get_class($operand);
            $processed['report'] = array_replace(
                $processed['report'],
                $operand -> getReport()
            );
        } catch (ValidationException $e) {
            $processed['exception'] = $e;
        } finally {
            if ($original_mode !== null) {
                $operand -> setValidationMode($original_mode);
            }
        }

        return $processed;
    }
}
