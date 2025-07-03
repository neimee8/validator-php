<?php

namespace Neimee8\ValidatorPhp\Tests\Rules\General;

use Neimee8\ValidatorPhp\Tests\RuleTestCase;
use Neimee8\ValidatorPhp\Tests\DataTypeManager;

use Neimee8\ValidatorPhp\Exceptions\ValidationParamsException;

class TypesTest extends RuleTestCase {
    use DataTypeManager;

    public function testStringPasses(): void {
        $this -> assertRulePasses('types', 'some string', ['string']);
        $this -> assertRulePasses('types', 'some string', ['string', 'int']);
        $this -> assertRulePasses('types', 'some string', ['?string']);
        $this -> assertRulePasses('types', 'some string', ['mixed']);
        $this -> assertRulePasses('types', 'some_string', self::$ALL_DATA_TYPES);
    }

    public function testStringFails(): void {
        $this -> assertRuleFails('types', 'some string', ['object']);
        $this -> assertRuleFails('types', 'some string', self::filterDataTypes(['string', '?string']));
        $this -> assertRuleFails('types', 'some string', ['?object']);
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
