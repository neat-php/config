<?php

namespace Neat\Config\ServiceBridge;

use Neat\Config\Config;
use Neat\Service\Container;

class ConfigProvider
{
    /**
     * @var Container
     */
    private $container;

    /**
     * @var Config
     */
    private $config;

    /**
     * ConfigProvider constructor.
     * @param Container $container
     * @param Config    $config
     */
    public function __construct(Container $container, Config $config)
    {
        $this->container = $container;
        $this->config    = $config;
    }

    public function register()
    {
        foreach ($this->config->getConfig() as $service => $concrete) {
            $this->container->set($service, $concrete);
        }
    }
}
