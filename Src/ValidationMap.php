<?php

declare(strict_types = 1);

namespace Neimee8\ValidatorPhp;

use \Closure;

use Neimee8\ValidatorPhp\Enums\ValidationMode;
use Neimee8\ValidatorPhp\Templates\MapTemplate;
use Neimee8\ValidatorPhp\Templates\ReportTemplate;

use Neimee8\ValidatorPhp\Input\Normalizers\MapNormalizer;
use Neimee8\ValidatorPhp\Input\Validators\MapValidator;
use Neimee8\ValidatorPhp\Processors\MapProcessor;

use Neimee8\ValidatorPhp\Exceptions\ValidationException;

final class ValidationMap extends ValidationAgent {
    private array $map;

    protected function init(): void {
        $this -> map = MapTemplate::getEmpty();

        static::$empty_report = ReportTemplate::getEmpty('map');
        static::$raw_retrieve_exception = fn() => new ValidationException(
            message: 'The map contains unprocessed or unvalidated values. '
                . 'To retrieve them anyway, set allow_raw = true'
        );

        parent::init();
    }

    public function __construct(
        array|self|null $map = null,
        ?ValidationMode $validation_mode = null
    ) {
        $this -> init();

        if ($validation_mode !== null) {
            $this -> setValidationMode($validation_mode);
        }

        if (is_array($map)) {
            $this -> setMap($map);
        } elseif ($map instanceof self) {
            $this -> fromObject($map);
        }
    }

    public function __clone() {
        foreach ($this -> map as $id => $entry) {
            $this -> map[$id] = clone $entry;
        }
    }

    public function setMap(array $map): void {
        $map = MapNormalizer::normalizeMap(
            $map,
            $this -> validation_mode
        );

        MapValidator::validateMap($map);

        $this -> map = $map;
        $this -> ready = true;
    }

    public function getMap(bool $allow_raw = false): array {
        return $this -> handleRetrieve(
            $allow_raw,
            function(): array {
                $map_to_retrieve = [];

                foreach ($this -> map as $id => $entry) {
                    $map_to_retrieve[$id] = clone $entry;
                }

                return $map_to_retrieve;
            }
        );
    }

    public function clearMap(): void {
        $this -> map = MapTemplate::getEmpty();
        $this -> ready = false;
    }

    public function getEntry(string|int $id): ValidationEntry {
        if (!$this -> entryExists($id)) {
            throw new ValidationException('entry not found');
        }

        return clone $this -> map[$id];
    }

    public function addEntry(
        array|ValidationEntry $entry,
        string|int|null $id = null
    ): void {
        if (
            $id !== null
            && $this -> entryExists($id)
        ) {
            throw new ValidationException('entry already exists');
        }

        $addEntryToMap = function() use ($id, $entry) {
            if ($id === null) {
                $this -> map[] = $entry;
            } else {
                $this -> map[$id] = $entry;
            }

            $this -> ready = true;
        };

        if ($entry instanceof ValidationEntry) {
            if ($entry -> isEmpty()) {
                throw new ValidationException('entry is empty');
            } else {
                $addEntryToMap();

                return;
            }
        }

        $entry = new ValidationEntry(
            $entry,
            $this -> validation_mode
        );

        $addEntryToMap();
    }

    public function replaceEntry(
        array|ValidationEntry $entry,
        string|int $id
    ): void {
        if (!$this -> entryExists($id)) {
            throw new ValidationException('entry not found');
        }

        if ($entry instanceof ValidationEntry) {
            if ($entry -> isEmpty()) {
                throw new ValidationException('entry is empty');
            } else {
                $this -> map[$id] = $entry;

                return;
            }
        }

        $this -> map[$id] = new ValidationEntry(
            $entry,
            $this -> validation_mode
        );
    }

    public function useEntry(
        string|int $id,
        Closure $handler
    ): void {
        if (!$this -> entryExists($id)) {
            throw new ValidationException('entry not found');
        }

        $entry = $this -> map[$id];
        $handler = $handler -> bindTo(null, null);

        $handler($entry);

        if ($entry -> isEmpty()) {
            $this -> clearEntry($id);
        }
    }

    public function useEntryOperand(
        string|int $id,
        Closure $handler
    ): void {
        if (!$this -> entryExists($id)) {
            throw new ValidationException('entry not found');
        }

        $entry = $this -> map[$id];
        $handler = $handler -> bindTo(null, null);

        $entry -> useOperand($handler);
    }

    public function clearEntry(string|int $id): void {
        if (!$this -> entryExists($id)) {
            throw new ValidationException('entry not found');
        }

        unset($this -> map[$id]);

        if ($this -> isEmpty()) {
            $this -> ready = false;
        }
    }

    public function entryExists(string|int $id): bool {
        return array_key_exists($id, $this -> map);
    }

    public function getEntryResult(string|int $id): bool {
        if (!array_key_exists($id, $this -> report['entries'])) {
            throw new ValidationException('Entry result not found');
        }

        return $this -> report['entries'][$id]['result'];
    }

    public function getEntryReport(string|int $id): array {
        if (!array_key_exists($id, $this -> report['entries'])) {
            throw new ValidationException('Entry report not found');
        }

        return $this -> report['entries'][$id];
    }

    public function isEmpty(): bool {
        return MapTemplate::isEmpty($this -> map);
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
            MapValidator::validateMap($this -> map);
        }

        $processed = MapProcessor::process(
            $this -> map,
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
        array|self $map,
        ?ValidationMode $validation_mode = null,
        bool $force_validation_mode = true,
        bool $collect_detailed = true,
        bool $return_report = false
    ): bool|array {
        $instance = $map instanceof self
            ? $map
            : new self(
                $map,
                $validation_mode
            );

        return $instance -> validate(
            $force_validation_mode,
            $collect_detailed,
            $return_report
        );
    }
}
