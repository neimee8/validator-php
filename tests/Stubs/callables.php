<?php

return [

    'arrow' => fn () => true,

    'closure' => function () {},

    'arrayCall' => [
        new class { function foo() {} },
        'foo'
    ],

    'invokable' => new class {
        public function __invoke() {}
    },
    
];
