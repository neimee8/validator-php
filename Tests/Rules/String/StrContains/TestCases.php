<?php

namespace Neimee8\ValidatorPhp\Tests\Rules\String\StrContains;

use Neimee8\ValidatorPhp\Tests\Rules\ParamTests\TestStringParamsTrait;

trait TestCases {
    use TestStringParamsTrait;

    private string $haystack = 'some_string';

    protected function assertPassesDefault(string $substring): void {
        foreach (static::getRules() as $rule) {
            $this -> {$this -> pass_method} (
                rule: $rule,
                value: $this -> haystack,
                params: $substring
            );
        }
    }

    protected function assertFailsDefault(string $substring): void {
        foreach (static::getRules() as $rule) {
            $this -> {$this -> fail_method} (
                rule: $rule,
                value: $this -> haystack,
                params: $substring
            );
        }
    }

    public function testPasses(): void {
        $substrings = [
            's',
            'o',
            'some',
            '_',
            'e_s'
        ];

        foreach ($substrings as $substring) {
            $this -> assertPassesDefault($substring);
        }
    }

    public function testFails(): void {
        $substrings = [
            '123',
            'abcde',
            'p',
            '+'
        ];

        foreach ($substrings as $substring) {
            $this -> assertFailsDefault($substring);
        }
    }
}
