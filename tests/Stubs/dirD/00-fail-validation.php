<?php

use Neat\Config\Test\Stubs\ConfigA;
use Neat\Config\Test\Stubs\ConfigB;

return [
    ConfigA::class => new ConfigB('host', 'username', 'password'),
];
