<?php

namespace Neimee8\ValidatorPhp\Tests\Rules\General;

use Neimee8\ValidatorPhp\Tests\RuleTestCase;

class TypesTest extends RuleTestCase {
    public function testPassesWithSufficientTypes(): void {
        $this -> assertRulePasses('types', 'some string', ['string', 'int']);
    }
}
