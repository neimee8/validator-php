<?php

declare(strict_types = 1);

namespace Neimee8\ValidatorPhp;

use \ReflectionObject;
use \ReflectionMethod;
use \Closure;

use Neimee8\ValidatorPhp\Enums\ValidationMode;

use Neimee8\ValidatorPhp\Exceptions\ValidationException;

abstract class ValidationAgent implements ValidationAgentInterface {
    protected static mixed $null_ref = null;

    public const DISALLOW_INCOMPATIBLE_VALUES = ValidationMode::DISALLOW_INCOMPATIBLE_VALUES;
    public const ALLOW_INCOMPATIBLE_VALUES = ValidationMode::ALLOW_INCOMPATIBLE_VALUES;

    protected array $methods;
    protected ValidationMode $validation_mode;

    protected bool $ready;
    protected array $report;

    protected static array|bool|null $empty_report;
    protected static Closure $raw_retrieve_exception;

    protected function init(): void {
        $this -> methods = get_class_methods($this);
        $this -> validation_mode = self::DISALLOW_INCOMPATIBLE_VALUES;

        $this -> ready = false;
        $this -> report = static::$empty_report;
    }

    protected function handleRetrieve(
        bool $allow_raw,
        Closure $retriever
    ): mixed {
        if (!$this -> ready && !$allow_raw) {
            throw (static::$raw_retrieve_exception)();
        }

        return $retriever();
    }

    public function fromObject(ValidationAgentInterface $instance): void {
        if (get_class($instance) !== static::class) {
            throw new ValidationException(
                'Expected instance type of ' 
                . static::class
                . ', '
                . get_class($instance)
                . ' given'
            );
        }

        $ref = new ReflectionObject($instance);

        foreach ($ref -> getProperties() as $property) {
            if (
                $property -> isStatic()
                || $property -> isReadOnly()
            ) {
                continue;
            }

            $property -> setAccessible(true);
            $value = $property -> getValue($instance);

            $property -> setValue($this, $value);
        }
    }

    public function setValidationMode(ValidationMode $validation_mode): void {
        $this -> validation_mode = $validation_mode;
    }

    public function getValidationMode(): ValidationMode {
        return $this -> validation_mode;
    }

    public function resetValidationMode(): void {
        $this -> validation_mode = self::DISALLOW_INCOMPATIBLE_VALUES;
    }

    public function getResult(): ?bool {
        return $this -> report['result'];
    }

    public function getReport(): array {
        return $this -> report;
    }

    public function clearReport(): void {
        $this -> report = static::$empty_report;
    }

    public function clear(): void {
        foreach ($this -> methods as $method) {
            if (
                str_starts_with($method, 'clear')
                && $method !== 'clear'
            ) {
                $ref = new ReflectionMethod($this, $method);

                if (
                    $ref -> getNumberOfParameters() === 0
                    && $ref -> isPublic()
                ) {
                    $this -> $method();
                }
            }
        }
    }

    public function reset(): void {
        foreach ($this -> methods as $method) {
            if (
                str_starts_with($method, 'reset')
                && $method !== 'reset'
            ) {
                $ref = new ReflectionMethod($this, $method);

                if (
                    $ref -> getNumberOfParameters() === 0
                    && $ref -> isPublic()
                ) {
                    $this -> $method();
                }
            }
        }
    }

    public function resetHard(): void {
        $this -> clear();
        $this -> reset();
    }

    public function isReady(): bool {
        return $this -> ready === true;
    }
}
