<?php

declare(strict_types = 1);

namespace Neimee8\ValidatorPhp\Processors;

use Neimee8\ValidatorPhp\Enums\ValidationMode;
use Neimee8\ValidatorPhp\Templates\ReportTemplate;

use Neimee8\ValidatorPhp\Input\Validators\ValueValidator;
use Neimee8\ValidatorPhp\Validators\Delegator;
use Neimee8\ValidatorPhp\Validators\Helpers\ValidationContext;

use Neimee8\ValidatorPhp\Exceptions\ValidationException;

final class NodeProcessor {
    use ProcessorHelper;

    public static function process(
        mixed $value,
        string $rule,
        array $params,
        ValidationMode $validation_mode
    ): array {
        $processed = self::$PROCESSED_TEMPLATE;
        $processed['report'] = ReportTemplate::getEmpty('node');

        $result = null;

        ValidationContext::enter();

        try {
            ValueValidator::validateValue($value, $rule);

            $result = Delegator::{$rule}($value, $params);
        } catch (ValidationException $e) {
            if ($validation_mode === ValidationMode::ALLOW_INCOMPATIBLE_VALUES) {
                $result = false;
            } elseif ($validation_mode === ValidationMode::DISALLOW_INCOMPATIBLE_VALUES) {
                $processed['exception'] = $e;
            }
        }

        ValidationContext::exit();

        self::collectReport(
            $processed['report'],
            $result,
            $rule,
            $params,
            $validation_mode
        );

        return $processed;
    }

    private static function collectReport(
        array &$storage,
        ?bool $result,
        string $rule,
        array $params,
        ValidationMode $validation_mode
    ): void {
        $storage['result'] = $result;
        $storage['rule'] = $rule;
        $storage['params'] = $params;
        $storage['validation_mode'] = $validation_mode;
    }
}
