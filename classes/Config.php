<?php

namespace Neat\Config;

use DirectoryIterator;

class Config
{
    /**
     * @var string[]
     */
    private $directories;

    /**
     * @var mixed[]
     */
    private $config;

    public function __construct(string ...$directories)
    {
        $this->directories = $directories;
    }

    /**
     * @return mixed[]
     */
    public function getConfig(): array
    {
        if (null === $this->config) {
            $this->init();
        }

        return $this->config;
    }

    /**
     * @param string $name
     * @return mixed|null
     */
    public function getByName(string $name)
    {
        if (null === $this->config) {
            $this->init();
        }

        return $this->config[$name] ?? null;
    }

    private function init()
    {
        $config = [];
        foreach ($this->directories() as $directory) {
            $config[] = $this->initDirectory($directory);
        }

        $this->config = array_merge(...$config);
        $this->validate();
    }

    /**
     * @param DirectoryIterator $directory
     * @return object[]
     */
    private function initDirectory(DirectoryIterator $directory): array
    {
        /** @var array[] $config */
        $config = [];
        foreach ($directory as $file) {
            if ($file->getExtension() !== 'php') {
                continue;
            }
            /** @noinspection PhpIncludeInspection */
            /** @var array $config */
            $directoryConfig = require $file->getPathname();
            $config[]        = $directoryConfig;
        }

        return array_merge(...$config);
    }

    public function validate()
    {
        foreach ($this->config as $name => $object) {
            if (!is_object($object) || $object instanceof \Closure) {
                continue;
            }
            if ($object instanceof $name) {
                continue;
            }
            $objectClass = get_class($object);
            throw new \RuntimeException("$objectClass is not an instance of $name");
        }
    }

    /**
     * @return DirectoryIterator[]
     */
    private function directories(): array
    {
        return array_map(function (string $directory) {
            return new DirectoryIterator(realpath($directory));
        }, $this->directories);
    }
}
