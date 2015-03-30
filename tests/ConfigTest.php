<?php

use Behinddesign\Chalkboard\Config;

class ChalkboardTest extends PHPUnit_Framework_TestCase
{
    private $fixturesPath;

    public function setUp()
    {
        parent::setUp();
        $this->fixturesPath = realpath(__DIR__ . '/fixtures');
    }

    public function testObjectIsCorrect()
    {
        $config = new Config();
        $this->assertInstanceOf('Behinddesign\Chalkboard\Config', $config);
    }

    public function testSingleFileByDirectory()
    {
        $config = new Config($this->fixturesPath . '/single_config');
        $this->assertEquals('b', $config->get('single_config.test_2'));
        $this->assertEquals('b', $config->get('test_2'));
    }

    public function testMulitpleFileByDirectory()
    {
        $config = new Config($this->fixturesPath . '/multiple_config');
        $this->assertEquals('grass', $config->get('config_a.green'));
        $this->assertEquals('snail', $config->get('config_b.low'));
    }

    public function testSingleFileByFile()
    {
        $config = new Config($this->fixturesPath . '/single_config/single_config.ini');
        $this->assertEquals('b', $config->get('single_config.test_2'));
        $this->assertEquals('b', $config->get('test_2'));
    }
}
