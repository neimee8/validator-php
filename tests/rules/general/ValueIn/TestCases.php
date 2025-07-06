<?php

namespace Neimee8\ValidatorPhp\Tests\Rules\General\ValueIn;

use Neimee8\ValidatorPhp\Tests\Stubs\MyClass;

use Neimee8\ValidatorPhp\Exceptions\ValidationParamsException;

trait TestCases {
    protected function assertPassesDefault(
        mixed $value,
        array $haystack
    ): void {
        $this -> {$this -> pass_method}(
            rule: $this -> rule,
            value: $value,
            params: $haystack
        );
    }

    protected function assertFailsDefault(
        mixed $value,
        array $haystack
    ): void {
        $this -> {$this -> fail_method}(
            rule: $this -> rule,
            value: $value,
            params: $haystack
        );
    }

    public function testValueFoundInHaystack(): void {
        $callable = fn() => true;
        $object = new class {};

        $values = [
            5,
            'a',
            1.5,
            $callable,
            [1, 2, 3],
            $object
        ];

        $haystacks = [
            [1, 2, 3, 4, 5, 6],
            ['a', 'b', 'c', 'd', 'e', 'f'],
            [0.5, 0.75, 1.0, 1.25, 1.5, 1.75],
            [$callable, fn() => false, fn($a) => $a],
            [
                [1, 5, 7],
                [1, 3, 5],
                [1, 2, 3]
            ],
            [new MyClass(), $object]
        ];

        for ($i = 0; $i < count($values); $i++) {
            $this -> assertPassesDefault(
                value: $values[$i],
                haystack: $haystacks[$i]
            );
        }
    }

    public function testValueNotFoundInHaystack(): void {
        $values = [
            5,
            'some_string',
            1.5,
            fn() => true,
            [1, 2, 'some_string'],
            new class {}
        ];
        $haystacks = [
            [],
            ['a', 'b', 'c', 'd', 'e', 'f'],
            [0.5, 0.75, 1.0, 1.25, 5, 1.75],
            [fn() => true, 'some_string'],
            [
                [1, 5, 7],
                [1, 3, 5],
                [1, 2, 3]
            ],
            [new MyClass()]
        ];

        for ($i = 0; $i < count($values); $i++) {
            $this -> assertFailsDefault(
                value: $values[$i],
                haystack: $haystacks[$i]
            );
        }
    }

    public function testIncompatibleParams(): void {
        $param_set = [
            5,
            5.5,
            'some_string',
            new class {},
            fn() => true,
            ['assoc' => 'array']
        ];

        foreach ($param_set as $params) {
            $this -> assertRuleThrows(
                rule: $this -> rule,
                value: null,
                params: $params,
                expected_exception: ValidationParamsException::class
            );
        }
    }
}
