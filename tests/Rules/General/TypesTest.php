<?php

namespace Neimee8\ValidatorPhp\Tests\Rules\General;

use Neimee8\ValidatorPhp\Tests\RuleTestCase;
use Neimee8\ValidatorPhp\Tests\DataTypeManager;

use Neimee8\ValidatorPhp\Tests\Stubs\MyClass;
use Neimee8\ValidatorPhp\Tests\Stubs\MyInterface;

use Neimee8\ValidatorPhp\Exceptions\ValidationParamsException;

class TypesTest extends RuleTestCase {
    use DataTypeManager;

    private function typesPassesDefault(mixed $value, string $type): void {
        $this -> assertRulePasses('types', $value, [$type]);
        $this -> assertRulePasses('types', $value, ["?$type"]);
        $this -> assertRulePasses('types', $value, ['mixed']);
        $this -> assertRulePasses('types', $value, self::getDataTypes());
    }

    private function typesFailsDefault(
        mixed $value,
        string $incompatible_type,
        array $excluded_types,
        bool $filter_nullable = true
    ): void {
        $this -> assertRuleFails('types', $value, [$incompatible_type]);
        $this -> assertRuleFails('types', $value, self::filterDataTypes($excluded_types, $filter_nullable));

        if ($filter_nullable) {
            $this -> assertRuleFails('types', $value, ["?$incompatible_type"]);
        }
    }

    public function testIntPasses(): void {
        $this -> typesPassesDefault(
            value: 0,
            type: 'int'
        );
    }

    public function testIntFails(): void {
        $this -> typesFailsDefault(
            value: 2,
            incompatible_type: 'object',
            excluded_types: ['int']
        );
    }

    public function testFloatPasses(): void {
        $this -> typesPassesDefault(
            value: 0.5,
            type: 'float'
        );
    }

    public function testFloatFails(): void {
        $this -> typesFailsDefault(
            value: 0.5,
            incompatible_type: 'object',
            excluded_types: ['float']
        );
    }

    public function testStringPasses(): void {
        $this -> typesPassesDefault(
            value: 'some_string',
            type: 'string'
        );
    }

    public function testStringFails(): void {
        $this -> typesFailsDefault(
            value: 'some_string',
            incompatible_type: 'object',
            excluded_types: ['string']
        );
    }

    public function testBoolPasses(): void {
        $this -> typesPassesDefault(
            value: true,
            type: 'bool'
        );
    }

    public function testBoolFails(): void {
        $this -> typesFailsDefault(
            value: true,
            incompatible_type: 'object',
            excluded_types: ['bool']
        );
    }

    public function testArrayPasses(): void {
        $this -> typesPassesDefault(
            value: [0, 1, 2],
            type: 'array'
        );
    }

    public function testArrayFails(): void {
        $this -> typesFailsDefault(
            value: [0, 1, 2],
            incompatible_type: 'object',
            excluded_types: ['array', 'iterable']
        );
    }

    public function testCallablePasses(): void {
        $arrow      = fn () => true;
        $closure    = function () {};
        $arrayCall  = [new class { function foo() {} }, 'foo'];
        $invokable  = new class { public function __invoke() {} };

        $this -> typesPassesDefault(
            value: $arrow,
            type: 'callable'
        );

        $this -> typesPassesDefault(
            value: $closure,
            type: 'callable'
        );

        $this -> typesPassesDefault(
            value: $arrayCall,
            type: 'callable'
        );

        $this -> typesPassesDefault(
            value: $invokable,
            type: 'callable'
        );
    }

    public function testCallableFails(): void {
        $this -> typesFailsDefault(
            value: fn () => true,
            incompatible_type: 'bool',
            excluded_types: ['callable', 'object']
        );
    }

    public function testObjectPasses(): void {
        $this -> typesPassesDefault(
            value: new class {},
            type: 'object'
        );
    }

    public function testObjectFails(): void {
        $this -> typesFailsDefault(
            value: new class {},
            incompatible_type: 'string',
            excluded_types: ['object']
        );
    }

    public function testResourcePasses(): void {
        $resource = fopen('php://memory', 'r');
    
        $this -> typesPassesDefault(
            value: $resource,
            type: 'resource'
        );

        fclose($resource);
    }

    public function testResourceFails(): void {
        $resource = fopen('php://memory', 'r');

        $this -> typesFailsDefault(
            value: $resource,
            incompatible_type: 'string',
            excluded_types: ['resource', 'object']
        );

        fclose($resource);
    }

    public function testIterablePasses(): void {
        $iterable = (function (): iterable {
            yield 1;
        })();

        $this -> typesPassesDefault(
            value: [0, 1, 2],
            type: 'iterable'
        );

        $this -> typesPassesDefault(
            value: $iterable,
            type: 'iterable'
        );
    }

    public function testIterableFails(): void {
        $iterable = (function (): iterable {
            yield 1;
        })();

        $this -> typesFailsDefault(
            value: [0, 1, 2],
            incompatible_type: 'string',
            excluded_types: ['iterable', 'array']
        );

        $this -> typesFailsDefault(
            value: $iterable,
            incompatible_type: 'string',
            excluded_types: ['iterable', 'object']
        );
    }

    public function testInstancePasses(): void {
        $this -> typesPassesDefault(
            value: new MyClass(),
            type: MyClass::class
        );

        $this -> typesPassesDefault(
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
            $this -> typesPassesDefault(
                value: null,
                type: $type
            );
        }
    }

    public function testNullFails(): void {
        $nullable_types = self::getNullableDataTypes();

        $this -> typesFailsDefault(
            value: null,
            incompatible_type: 'string',
            excluded_types: $nullable_types,
            filter_nullable: false
        );
    }

    public function testIncompatibleParams(): void {
        $this -> assertRuleThrows('types', null, 'some_string', ValidationParamsException::class);
        $this -> assertRuleThrows('types', null, ['some_string' => 'some_string'], ValidationParamsException::class);
        $this -> assertRuleThrows(
            'types',
            null,
            [
                ['some_string', 'some_string'],
                ['some_string', 'some_string']
            ],
            ValidationParamsException::class
        );
    }
}
