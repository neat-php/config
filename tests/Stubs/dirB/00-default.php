<?php

use Neat\Config\Test\Stubs\ConfigB;
use Neat\Config\Test\Stubs\ConfigC;

return [
    ConfigB::class => new ConfigB('example.com', 'username', 'password'),
    ConfigC::class => new ConfigC('key'),
];
