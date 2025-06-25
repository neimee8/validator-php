<?php

namespace Neimee8\ValidatorPhp;

use Neimee8\ValidatorPhp\Enums\ValidationMode;
use Neimee8\ValidatorPhp\Enums\ValidationMapType;

use Neimee8\ValidatorPhp\Exceptions\ValidationModeException;
use Neimee8\ValidatorPhp\Exceptions\ValidationMapTypeException;
use Neimee8\ValidatorPhp\Exceptions\ValidationEntryException;
use Neimee8\ValidatorPhp\Exceptions\ValidationException;

class ValidationMap {
    public const THROW_EXCEPTION = ValidationMode::THROW_EXCEPTION;
    public const SILENT = ValidationMode::SILENT;

    public const MAP_INDEXED = ValidationMapType::MAP_INDEXED;
    public const MAP_ASSOC = ValidationMapType::MAP_ASSOC;

    private array $map = [];
    private ValidationMapType $map_type;
    private array $result = [
        'result' => null,
        'report' => []
    ];

    public function __construct(
        ?array $entries = null,
        ValidationMapType $map_type = self::MAP_ASSOC
    ) {
        if (Validator::value_not_in($map_type, ValidationMapType::cases())) {
            throw new ValidationMapTypeException(map_type: $map_type);
        }

        $this -> map_type = $map_type;

        if ($entries !== null) {
            $this -> addEntries($entries);
        }
    }

    private static function prepareEntry(array &$entry): void {
        if (
            !ValidationRules::quickValidate($entry, [
                'type' => 'array',
                'arr_is_indexed' => true,
                'arr_len' => 2
            ], ValidationRules::SILENT)['result']
        ) {
            throw new ValidationEntryException(entry: $entry);
        }

        if (!Validator::types($entry[1], [ValidationRules::class, 'array'])) {
            throw new ValidationEntryException(entry: $entry);
        }

        if (is_array($entry[1])) {
            $entry[1] = new ValidationRules($entry[1]);
        }
    }

    public function addEntry(array $entry): void {
        if ($this -> map_type !== self::MAP_INDEXED) {
            throw new ValidationMapTypeException('You should use MAP_INDEXED to call this method, used ' . $this -> map_type -> name);
        }

        self::prepareEntry($entry);

        $this -> map[] = $entry;
    }

    public function addAssocEntry(int|string $key, array $entry): void {
        if ($this -> map_type !== self::MAP_ASSOC) {
            throw new ValidationMapTypeException('You should use MAP_ASSOC to call this method, used ' . $this -> map_type -> name);
        }

        self::prepareEntry($entry);

        $this -> map[$key] = $entry;
    }

    public function addEntries(array $entries): void {
        foreach ($entries as $key => $entry) {
            if ($this -> map_type === self::MAP_INDEXED) {
                $this -> addEntry($entry);
            } else {
                $this -> addAssocEntry($key, $entry);
            }
        }
    }

    public function clearEntries(): void {
        $this -> map = [];
    }

    public function clearEntry(int|string $key): void {
        if ($this -> entryExists($key)) {
            unset($this -> map[$key]);
        }
    }

    public function getFullResult(): array {
        return $this -> result;
    }

    public function getResult(): ?bool {
        return $this -> result['result'];
    }

    public function getReport(): array {
        return $this -> result['report'];
    }

    public function entryExists(int|string $key): bool {
        return array_key_exists($key, $this -> map);
    }

    public function validate(ValidationMode $mode = self::THROW_EXCEPTION): array {
        if (Validator::value_not_in($mode, ValidationMode::cases())) {
            throw new ValidationModeException(mode: $mode);
        }

        $this -> result = [
            'result' => null,
            'report' => []
        ];

        if ($this -> map === []) {
            return $this -> result;
        }

        foreach ($this -> map as $key => $entry) {
            $validation_result = true;

            try {
                $validation_result = $entry[1] -> validate($entry[0], $mode);
            } catch (ValidationException $e) {
                $this -> result['result'] = false;

                throw $e;
            }

            if (!$validation_result['result']) {
                $this -> result['result'] = false;
            }

            $this -> result['report'][$key] = $validation_result['report'];
        }

        if ($this -> result['result'] === null) {
            $this -> result['result'] = true;
        }

        return $this -> result;
    }

    public static function quickValidate(
        array $entries,
        ValidationMapType $map_type = self::MAP_ASSOC,
        ValidationMode $mode = self::THROW_EXCEPTION
    ): array {
        $instance = new self($entries, $map_type);

        return $instance -> validate($mode);
    }
}
