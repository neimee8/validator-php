<?php

declare(strict_types = 1);

namespace Neimee8\ValidatorPhp\Processors;

use \Throwable;

final class LogicProcessor {
    private string $logic;
    private bool $invert;

    private bool $result = false;
    private bool $short_circuited = false;

    public function __construct(
        string $logic,
        bool $invert = false
    ) {
        $this -> logic = $logic;
        $this -> invert = $invert;
    }

    public function feed(bool $value): void {
        if (!$this -> short_circuited) {
            try {
                $this -> {$this -> logic}($value);
            } catch (Throwable) {}
        }
    }

    public function getResult(): bool {
        return $this -> invert
            ? !$this -> result
            : $this -> result;
    }

    private function all(bool $value): void {
        $this -> result = $value;

        if (!$value) {
            $this -> short_circuited = true;
        }
    }

    private function any(bool $value): void {
        $this -> result = $value;

        if ($value) {
            $this -> short_circuited = true;
        }
    }

    private function none(bool $value): void {
        $this -> result = !$value;

        if ($value) {
            $this -> short_circuited = true;
        }
    }

    private function one(bool $value): void {
        if ($value) {
            if ($this -> result) {
                $this -> result = false;
                $this -> short_circuited = true;
            } else {
                $this -> result = true;
            }
        }
    }
}
