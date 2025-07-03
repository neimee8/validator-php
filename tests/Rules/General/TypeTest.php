<?php

namespace Neimee8\ValidatorPhp\Tests\Rules\General;

use Neimee8\ValidatorPhp\Tests\RuleTestCase;
use Neimee8\ValidatorPhp\Tests\DataTypeManager;

use Neimee8\ValidatorPhp\Tests\Stubs\MyClass;
use Neimee8\ValidatorPhp\Tests\Stubs\MyInterface;

use Neimee8\ValidatorPhp\Exceptions\ValidationParamsException;

class TypeTest extends RuleTestCase {
    use DataTypeManager;

    private function typePassesDefault(
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
                $this -> assertRulePasses(
                    rule: 'type',
                    value: $value,
                    params: $params
                );
            }
        }
    }

    private function typeFailsDefault(
        mixed $value,
        array $types_to_filter,
        bool $filter_nullable = true
    ): void {
        $types = self::filterDataTypes(
            $types_to_filter,
            $filter_nullable
        );

        foreach ($types as $type) {
            $this -> assertRuleFails(
                rule: 'type',
                value: $value,
                params: $type
            );
        }
    }

    public function testIntPasses(): void {
        $this -> typePassesDefault(
            value: 0,
            types: ['int']
        );
    }

    public function testIntFails(): void {
        $this -> typeFailsDefault(
            value: 0,
            types_to_filter: ['int']
        );
    }

    public function testFloatPasses(): void {
        $this -> typePassesDefault(
            value: 0.5,
            types: ['float']
        );
    }

    public function testFloatFails(): void {
        $this -> typeFailsDefault(
            value: 0.5,
            types_to_filter: ['float']
        );
    }

    public function testStringPasses(): void {
        $this -> typePassesDefault(
            value: 'some_string',
            types: ['string']
        );
    }

    public function testStringFails(): void {
        $this -> typeFailsDefault(
            value: 'some_string',
            types_to_filter: ['string']
        );
    }

    public function testBoolPasses(): void {
        $this -> typePassesDefault(
            value: true,
            types: ['bool']
        );

        $this -> typePassesDefault(
            value: false,
            types: ['bool']
        );
    }

    public function testBoolFails(): void {
        $this -> typeFailsDefault(
            value: true,
            types_to_filter: ['bool']
        );
    }

    public function testArrayPasses(): void {
        $this -> typePassesDefault(
            value: [0, 1, 2],
            types: ['array', 'iterable']
        );
    }

    public function testArrayFails(): void {
        $this -> typeFailsDefault(
            value: [0, 1, 2],
            types_to_filter: ['array', 'iterable']
        );
    }

    public function testCallablePasses(): void {
        $callables = require __DIR__
        . '/../../../'
        . self::$STUB_DIR
        . 'callables.php';

        foreach ($callables as $callable) {
            $this -> typePassesDefault(
                value: $callable,
                types: ['callable']
            );
        }
    }

    public function testCallableFails(): void {
        $this -> typeFailsDefault(
            value: fn () => true,
            types_to_filter: ['callable', 'object']
        );
    }

    public function testObjectPasses(): void {
        $this -> typePassesDefault(
            value: new class {},
            types: ['object']
        );
    }

    public function testObjectFails(): void {
        $this -> typeFailsDefault(
            value: new class {},
            types_to_filter: ['object']
        );
    }

    public function testResourcePasses(): void {
        $resource = fopen('php://memory', 'r');

        $this -> typePassesDefault(
            value: $resource,
            types: ['resource']
        );

        fclose($resource);
    }

    public function testResourceFails(): void {
        $resource = fopen('php://memory', 'r');

        $this -> typeFailsDefault(
            value: $resource,
            types_to_filter: ['resource', 'object']
        );

        fclose($resource);
    }

    public function testIterablePasses(): void {
        $iterables = require __DIR__
        . '/../../../'
        . self::$STUB_DIR
        . 'iterables.php';

        foreach ($iterables as $iterable) {
            $this -> typePassesDefault(
                value: $iterable,
                types: ['iterable']
            );
        }
    }

    public function testIterableFails(): void {
        $iterables = require __DIR__
        . '/../../../'
        . self::$STUB_DIR
        . 'iterables.php';

        $this -> typeFailsDefault(
            value: $iterables['array'],
            types_to_filter: ['iterable', 'array']
        );

        $this -> typeFailsDefault(
            value: $iterables['generator'],
            types_to_filter: ['iterable', 'object']
        );
    }

    public function testInstancePasses(): void {
        $this -> typePassesDefault(
            value: new MyClass(),
            types: [MyClass::class]
        );

        $this -> typePassesDefault(
            value: new MyClass(),
            types: [MyInterface::class]
        );
    }

    public function testNullPasses(): void {
        $this -> typePassesDefault(
            value: null,
            types:  [
                ...self::getNullableDataTypes(),
                '?' . MyClass::class
            ]
        );
    }

    public function testNullFails(): void {
        $nullable_types = self::getNullableDataTypes();

        $this -> typeFailsDefault(
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
                rule: 'type',
                value: null,
                params: $params,
                expected_exception: ValidationParamsException::class
            );
        }
    }
}
