<?php

namespace Neimee8\ValidatorPhp\Tests\Rules\String;

use Neimee8\ValidatorPhp\Tests\Rules\MustBeRuleTestCases;

/**
 * @group rules
 * @group string
 */
class StrEmailTest extends MustBeRuleTestCases {
    protected static array $rules = ['str_email'];
    
    protected static function getCompatibleValue(): string {
        return 'some_string';
    }

    protected static function getValuesToPass(): array {
        return [
            'lorem@ipsum.com',
            'john@gmail.com',
            'long.email.address.for.test.purposes@inbox.lv'
        ];
    }

    protected static function getValuesToFail(): array {
        return [
            'very.long.email.address.for.test.purposes.lorem.ipsum.dolor'
            . '.sit.amet.consectetur.adipiscing.elit.sed.do.eiusmod.tempor'
            . '.incididunt.ut.labore.et.dolore.magna.aliqua@gmail.com',

            'incorrectgmail.com',
            '@gmail.com',
            'incorrect@gmail',
            'incorrect@gmail.'
        ];
    }
}
