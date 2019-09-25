<?php

use Neat\Config\Test\Stubs\ConfigA;

return [
    ConfigA::class => new ConfigA('sqlite::memory'),
];
