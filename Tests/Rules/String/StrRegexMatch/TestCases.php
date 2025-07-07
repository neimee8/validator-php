<?php

namespace Neimee8\ValidatorPhp\Tests\Rules\String\StrRegexMatch;

use Neimee8\ValidatorPhp\Tests\Rules\ParamTests\TestRegexParamsTrait;

trait TestCases {
    use TestRegexParamsTrait;

    private string $reference = 'some_string';

    protected function assertPassesDefault(string $pattern): void {
        foreach (static::getRules() as $rule) {
            $this -> {$this -> pass_method} (
                rule: $rule,
                value: $this -> reference,
                params: $pattern
            );
        }
    }

    protected function assertFailsDefault(string $pattern): void {
        foreach (static::getRules() as $rule) {
            $this -> {$this -> fail_method} (
                rule: $rule,
                value: $this -> reference,
                params: $pattern
            );
        }
    }

    public function testPasses(): void {
        $patterns = [
            '/^[a-z0-9_]+$/i',
            '/string/',
            '/^\w+_\w+$/'
        ];

        foreach ($patterns as $pattern) {
            $this -> assertPassesDefault($pattern);
        }
    }

    public function testFails(): void {
        $patterns = [
            '/^\d+$/',
            '/^[a-z]+$/',
            '/^[A-Z]+$/'
        ];

        foreach ($patterns as $pattern) {
            $this -> assertFailsDefault($pattern);
        }
    }
}
