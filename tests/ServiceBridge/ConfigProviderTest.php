<?php

namespace Neat\Config\Test\ServiceBridge;

use Neat\Config\Config;
use Neat\Config\ServiceBridge\ConfigProvider;
use Neat\Config\Test\Stubs\ConfigB;
use Neat\Config\Test\Stubs\ConfigC;
use Neat\Service\Container;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ConfigProviderTest extends TestCase
{
    public function testRegister()
    {
        /** @var Container|MockObject $container */
        $container = $this->getMockBuilder(Container::class)->disableOriginalConstructor()->getMock();
        $configB   = new ConfigB('example.com', 'username', 'password', 5);
        $container->expects($this->at(0))
            ->method('set')
            ->with(ConfigB::class, $configB);
        $container->expects($this->at(1))
            ->method('set')
            ->with(ConfigC::class, new ConfigC('key'));
        $config         = new Config('tests/Stubs/dirB');
        $configProvider = new ConfigProvider($container, $config);
        $configProvider->register();
    }
}
