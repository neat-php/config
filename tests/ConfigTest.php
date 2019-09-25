<?php /** @noinspection PhpIncludeInspection */

namespace Neat\Config\Test;

use Neat\Config\Config;
use Neat\Config\Test\Stubs\ConfigA;
use Neat\Config\Test\Stubs\ConfigB;
use Neat\Config\Test\Stubs\ConfigC;
use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase
{
    public function testInit()
    {
        $config = new Config($this->dir('a'));
        /** @var array $expected */
        $expected = require 'Stubs/dirA/00-default.php';
        $this->assertEquals($expected, $config->getConfig());
        $this->assertEquals($expected[ConfigA::class], $config->getByName(ConfigA::class));
    }

    public function testOverwrites()
    {
        $config   = new Config($this->dir('b'));
        $expected = [
            ConfigC::class => new ConfigC('key'),
            ConfigB::class => new ConfigB('example.com', 'username', 'password', 5),
        ];
        $this->assertEquals($expected, $config->getConfig());
        $this->assertEquals($expected[ConfigB::class], $config->getByName(ConfigB::class));
    }

    public function testMultipleDirectories()
    {
        $config    = new Config($this->dir('a'), $this->dir('b'));
        $expectedA = require 'Stubs/dirA/00-default.php';
        $expectedB = require 'Stubs/dirB/00-default.php';
        $expectedC = require 'Stubs/dirB/10-overwrite.php';
        $expected  = array_merge($expectedA, $expectedB, $expectedC);
        $this->assertEquals($expected, $config->getConfig());
        $this->assertEquals($expected[ConfigB::class], $config->getByName(ConfigB::class));
    }

    public function testRelativePaths()
    {
        $config   = new Config($this->dir('a', false));
        $expected = require 'Stubs/dirA/00-default.php';
        $this->assertEquals($expected, $config->getConfig());
        $this->assertEquals($expected[ConfigA::class], $config->getByName(ConfigA::class));
    }

    public function testScalar()
    {
        $config   = new Config($this->dir('c'));
        $expected = require 'Stubs/dirC/00-scalar-test.php';
        $this->assertEquals($expected, $config->getConfig());
    }

    public function testValidation()
    {
        $config = new Config($this->dir('d'));
        $this->expectExceptionObject(new \RuntimeException(ConfigB::class . ' is not an instance of ' . ConfigA::class));
        $config->getConfig();
    }

    private function dir(string $dir, bool $absolute = true): string
    {
        $dir = strtoupper($dir);
        if ($absolute) {
            return __DIR__ . '/Stubs/dir' . $dir;
        }

        return "tests/Stubs/dir{$dir}";
    }
}
