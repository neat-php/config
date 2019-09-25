<?php

use Neat\Config\Test\Stubs\ConfigA;

return [
    'key'          => 'value',
    'array'        => [],
    ConfigA::class => function (): ConfigA {
        return new ConfigA('dsn', 'username', 'password');
    },
];
