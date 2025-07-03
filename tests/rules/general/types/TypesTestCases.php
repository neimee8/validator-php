<?php

namespace Neimee8\ValidatorPhp\Tests\Rules\General\Types;

use Neimee8\ValidatorPhp\Tests\Variables;
use Neimee8\ValidatorPhp\Tests\DataTypeManager;

use Neimee8\ValidatorPhp\Tests\Stubs\MyClass;
use Neimee8\ValidatorPhp\Tests\Stubs\MyInterface;

use Neimee8\ValidatorPhp\Exceptions\ValidationParamsException;

trait TypesTestCases {
    use DataTypeManager, Variables;

    private function assertPassesDefault(
        mixed $value,
        string $type
    ): void {
        $param_set = [
            [$type],
            ["?$type"],
            ['mixed'],
            self::getDataTypes()
        ];

        foreach ($param_set as $params) {
            $this -> {$this -> pass_method}(
                rule: $this -> rule,
                value: $value, 
                params: $params
            );
        }
    }

    private function assertFailsDefault(
        mixed $value,
        string $incompatible_type,
        array $excluded_types,
        bool $filter_nullable = true
    ): void {
        $param_set = [
            [$incompatible_type],
            self::filterDataTypes(
                $excluded_types,
                $filter_nullable
            )
        ];

        foreach ($param_set as $params) {
            $this -> {$this -> fail_method}(
                rule: $this -> rule,
                value: $value,
                params: $params
            );
        }

        if ($filter_nullable) {
            $this -> {$this -> fail_method}(
                rule: $this -> rule,
                value: $value,
                params: ["?$incompatible_type"]
            );
        }
    }

    public function testIntPasses(): void {
        $this -> assertPassesDefault(
            value: 0,
            type: 'int'
        );
    }

    public function testIntFails(): void {
        $this -> assertFailsDefault(
            value: 2,
            incompatible_type: 'object',
            excluded_types: ['int']
        );
    }

    public function testFloatPasses(): void {
        $this -> assertPassesDefault(
            value: 0.5,
            type: 'float'
        );
    }

    public function testFloatFails(): void {
        $this -> assertFailsDefault(
            value: 0.5,
            incompatible_type: 'object',
            excluded_types: ['float']
        );
    }

    public function testStringPasses(): void {
        $this -> assertPassesDefault(
            value: 'some_string',
            type: 'string'
        );
    }

    public function testStringFails(): void {
        $this -> assertFailsDefault(
            value: 'some_string',
            incompatible_type: 'object',
            excluded_types: ['string']
        );
    }

    public function testBoolPasses(): void {
        $this -> assertPassesDefault(
            value: true,
            type: 'bool'
        );

        $this -> assertPassesDefault(
            value: false,
            type: 'bool'
        );
    }

    public function testBoolFails(): void {
        $this -> assertFailsDefault(
            value: true,
            incompatible_type: 'object',
            excluded_types: ['bool']
        );
    }

    public function testArrayPasses(): void {
        $this -> assertPassesDefault(
            value: [0, 1, 2],
            type: 'array'
        );
    }

    public function testArrayFails(): void {
        $this -> assertFailsDefault(
            value: [0, 1, 2],
            incompatible_type: 'object',
            excluded_types: ['array', 'iterable']
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
                type: 'callable'
            );
        }
    }

    public function testCallableFails(): void {
        $this -> assertFailsDefault(
            value: fn () => true,
            incompatible_type: 'bool',
            excluded_types: ['callable', 'object']
        );
    }

    public function testObjectPasses(): void {
        $this -> assertPassesDefault(
            value: new class {},
            type: 'object'
        );
    }

    public function testObjectFails(): void {
        $this -> assertFailsDefault(
            value: new class {},
            incompatible_type: 'string',
            excluded_types: ['object']
        );
    }

    public function testResourcePasses(): void {
        $resource = fopen('php://memory', 'r');
    
        $this -> assertPassesDefault(
            value: $resource,
            type: 'resource'
        );

        fclose($resource);
    }

    public function testResourceFails(): void {
        $resource = fopen('php://memory', 'r');

        $this -> assertFailsDefault(
            value: $resource,
            incompatible_type: 'string',
            excluded_types: ['resource', 'object']
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
                type: 'iterable'
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
            incompatible_type: 'string',
            excluded_types: ['iterable', 'array']
        );

        $this -> assertFailsDefault(
            value: $iterables['generator'],
            incompatible_type: 'string',
            excluded_types: ['iterable', 'object']
        );
    }

    public function testInstancePasses(): void {
        $this -> assertPassesDefault(
            value: new MyClass(),
            type: MyClass::class
        );

        $this -> assertPassesDefault(
            value: new MyClass(),
            type: MyInterface::class
        );
    }

    public function testNullPasses(): void {
        $nullable_types = [
            ...self::getNullableDataTypes(),
            '?' . MyClass::class
        ];

        foreach ($nullable_types as $type) {
            $this -> assertPassesDefault(
                value: null,
                type: $type
            );
        }
    }

    public function testNullFails(): void {
        $nullable_types = self::getNullableDataTypes();

        $this -> assertFailsDefault(
            value: null,
            incompatible_type: 'string',
            excluded_types: $nullable_types,
            filter_nullable: false
        );
    }

    public function testIncompatibleParams(): void {
        $param_set = [
            null,
            0,
            0.5,
            'some_string',
            true,
            fn () => true,
            new class {},
            ['some_string' => 'some_string'],
            [
                ['some_string', 'some_string'],
                ['some_string', 'some_string']
            ]
        ];

        foreach ($param_set as $params) {
            $this -> assertRuleThrows(
                rule: 'types',
                value: null,
                params: $params,
                expected_exception: ValidationParamsException::class
            );
        }
    }
}
