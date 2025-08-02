<?php

declare(strict_types = 1);

namespace Neimee8\ValidatorPhp\Processors;

use Neimee8\ValidatorPhp\Enums\ValidationMode;
use Neimee8\ValidatorPhp\Templates\ReportTemplate;

use Neimee8\ValidatorPhp\ValidationEntry;

use Neimee8\ValidatorPhp\Exceptions\ValidationException;

final class MapProcessor {
    use ProcessorHelper;

    public static function process(
        array $map,
        ValidationMode $validation_mode,
        bool $force_validation_mode,
        bool $collect_detailed
    ): array {
        $processed = self::$PROCESSED_TEMPLATE;
        $processed['report'] = ReportTemplate::getEmpty('map');

        $logic_processor = new LogicProcessor('all');

        foreach ($map as $id => $entry) {
            $original_mode = null;

            if ($force_validation_mode) {
                $original_mode = $entry -> getValidationMode();
                $entry -> setValidationMode($validation_mode);
            }

            try {
                $result = $entry -> validate(
                    $force_validation_mode,
                    $collect_detailed
                );

                self::collectEntryReport(
                    storage: $processed['report']['entries'],
                    id: $id,
                    entry: $entry
                );

                $logic_processor -> feed($result);
            } catch (ValidationException $e) {
                $processed['exception'] = $e;

                break;
            } finally {
                if ($original_mode !== null) {
                    $entry -> setValidationMode($original_mode);
                }
            }
        }

        $processed['report']['result'] = $processed['exception'] === null
            ? $logic_processor -> getResult()
            : null;

        return $processed;
    }

    private static function collectEntryReport(
        array &$storage,
        string|int $id,
        ValidationEntry $entry
    ): void {
        $storage[$id] = $entry -> getReport();
    }
}
