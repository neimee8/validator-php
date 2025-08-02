<?php

declare(strict_types = 1);

namespace Neimee8\ValidatorPhp\Templates;

final class ReportTemplate {
    public static function getEmpty(string $type): ?array {
        $templates = [
            'node' => self::getNodeReportEmpty(),
            'expression' => self::getExpressionReportEmpty(),
            'entry' => self::getEntryReportEmpty(),
            'map' => self::getMapReportEmpty()
        ];

        $templates['expression']['detailed'] = [
            'nodes' => [],
            'expressions' => []
        ];

        return $templates[$type] ?? null;
    }

    public static function getNodeReportEmpty(): array {
        return [
            'result' => null,
            'rule' => null,
            'params' => [],
            'parent_logic' => null,
            'validation_mode' => null,
            'force_validation_mode' => null
        ];
    }

    public static function getExpressionReportEmpty(): array {
        return [
            'result' => null,
            'logic' => null,
            'invert' => null,
            'parent_logic' => null,
            'validation_mode' => null,
            'force_validation_mode' => null
        ];
    }

    public static function getEntryReportEmpty(): array {
        return [
            'result' => null,
            'operand_class' => null
        ];
    }

    public static function getMapReportEmpty(): array {
        return [
            'result' => null,
            'entries' => []
        ];
    }
}
