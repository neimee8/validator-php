<?php

namespace Neimee8\ValidatorPhp\Tests\Rules\General\Type;

use Neimee8\ValidatorPhp\Tests\Variables;
use Neimee8\ValidatorPhp\Tests\Rules\DataTypeManager;

use Neimee8\ValidatorPhp\Tests\Stubs\MyClass;
use Neimee8\ValidatorPhp\Tests\Stubs\MyInterface;

use Neimee8\ValidatorPhp\Exceptions\ValidationParamsException;

trait TestCases {
    use DataTypeManager, Variables;

    protected function assertPassesDefault(
        mixed $value,
        array $types
    ): void {
        foreach ($types as $type) {
            $param_set = [
                $type,
                "?$type",
                'mixed'
            ];

            foreach ($param_set as $params) {
                $this -> {$this -> pass_method}(
                    rule: $this -> rule,
                    value: $value,
                    params: $params
                );
            }
        }
    }

    protected function assertFailsDefault(
        mixed $value,
        array $types_to_filter,
        bool $filter_nullable = true
    ): void {
        $types = self::filterDataTypes(
            $types_to_filter,
            $filter_nullable
        );

        foreach ($types as $type) {
            $this -> {$this -> fail_method}(
                rule: $this -> rule,
                value: $value,
                params: $type
            );
        }
    }

    public function testIntPasses(): void {
        $this -> assertPassesDefault(
            value: 0,
            types: ['int']
        );
    }

    public function testIntFails(): void {
        $this -> assertFailsDefault(
            value: 0,
            types_to_filter: ['int']
        );
    }

    public function testFloatPasses(): void {
        $this -> assertPassesDefault(
            value: 0.5,
            types: ['float']
        );
    }

    public function testFloatFails(): void {
        $this -> assertFailsDefault(
            value: 0.5,
            types_to_filter: ['float']
        );
    }

    public function testStringPasses(): void {
        $this -> assertPassesDefault(
            value: 'some_string',
            types: ['string']
        );
    }

    public function testStringFails(): void {
        $this -> assertFailsDefault(
            value: 'some_string',
            types_to_filter: ['string']
        );
    }

    public function testBoolPasses(): void {
        $this -> assertPassesDefault(
            value: true,
            types: ['bool']
        );

        $this -> assertPassesDefault(
            value: false,
            types: ['bool']
        );
    }

    public function testBoolFails(): void {
        $this -> assertFailsDefault(
            value: true,
            types_to_filter: ['bool']
        );
    }

    public function testArrayPasses(): void {
        $this -> assertPassesDefault(
            value: [0, 1, 2],
            types: ['array', 'iterable']
        );
    }

    public function testArrayFails(): void {
        $this -> assertFailsDefault(
            value: [0, 1, 2],
            types_to_filter: ['array', 'iterable']
        );
    }

    public function testCallablePasses(): void {
        $callables = require __DIR__
        . '/../../../../'
        . self::$STUB_DIR
        . 'callables.php';

        foreach ($callables as $callable) {
            $this -> assertPassesDefault(
                value: $callable,
                types: ['callable']
            );
        }
    }

    public function testCallableFails(): void {
        $this -> assertFailsDefault(
            value: fn () => true,
            types_to_filter: ['callable', 'object']
        );
    }

    public function testObjectPasses(): void {
        $this -> assertPassesDefault(
            value: new class {},
            types: ['object']
        );
    }

    public function testObjectFails(): void {
        $this -> assertFailsDefault(
            value: new class {},
            types_to_filter: ['object']
        );
    }

    public function testResourcePasses(): void {
        $resource = fopen('php://memory', 'r');

        $this -> assertPassesDefault(
            value: $resource,
            types: ['resource']
        );

        fclose($resource);
    }

    public function testResourceFails(): void {
        $resource = fopen('php://memory', 'r');

        $this -> assertFailsDefault(
            value: $resource,
            types_to_filter: ['resource', 'object']
        );

        fclose($resource);
    }

    public function testIterablePasses(): void {
        $iterables = require __DIR__
        . '/../../../../'
        . self::$STUB_DIR
        . 'iterables.php';

        foreach ($iterables as $iterable) {
            $this -> assertPassesDefault(
                value: $iterable,
                types: ['iterable']
            );
        }
    }

    public function testIterableFails(): void {
        $iterables = require __DIR__
        . '/../../../../'
        . self::$STUB_DIR
        . 'iterables.php';

        $this -> assertFailsDefault(
            value: $iterables['array'],
            types_to_filter: ['iterable', 'array']
        );

        $this -> assertFailsDefault(
            value: $iterables['generator'],
            types_to_filter: ['iterable', 'object']
        );
    }

    public function testInstancePasses(): void {
        $this -> assertPassesDefault(
            value: new MyClass(),
            types: [MyClass::class]
        );

        $this -> assertPassesDefault(
            value: new MyClass(),
            types: [MyInterface::class]
        );
    }

    public function testNullPasses(): void {
        $this -> assertPassesDefault(
            value: null,
            types:  [
                ...self::getNullableDataTypes(),
                '?' . MyClass::class
            ]
        );
    }

    public function testNullFails(): void {
        $nullable_types = self::getNullableDataTypes();

        $this -> assertFailsDefault(
            value: null,
            types_to_filter: $nullable_types
        );
    }

    public function testIncompatibleParams(): void {
        $param_set = [
            null,
            0,
            0.5,
            true,
            [1, 2, 3],
            fn () => true,
            new class {},
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
