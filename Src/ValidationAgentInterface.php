<?php

declare(strict_types = 1);

namespace Neimee8\ValidatorPhp;

use Neimee8\ValidatorPhp\Enums\ValidationMode;

interface ValidationAgentInterface {
    public function fromObject(ValidationAgentInterface $instance): void;

    public function setValidationMode(ValidationMode $validation_mode): void;
    public function getValidationMode(): ValidationMode;

    public function getResult(): ?bool;
    public function getReport(): array;
    public function clearReport(): void;

    public function clear(): void;
    public function reset(): void;
    public function resetHard(): void;

    public function isReady(): bool;
    public function isEmpty(): bool;

    public function validate(bool $return_report): bool|array;
}
