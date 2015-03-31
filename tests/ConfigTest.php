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

    //TODO : SHOULD accept this if we specify a file name implicitly.
    public function testNoneExistentNamespace()
    {
        $this->setExpectedException('Behinddesign\Chalkboard\Exceptions\NamespaceNotFoundException');

        $config = new Config($this->fixturesPath . '/multiple_config');
        $config->get('test_write_2');
    }

    public function testSingleFileMultipleDimension()
    {
        $config = new Config($this->fixturesPath . '/single_config/single_config.ini');
        $config->set('test_6.test_a.test_b', 'e');
        $this->assertEquals('e', $config->get('test_6.test_a.test_b'));
    }

    public function testWriteToSingleFileNoDotNotation()
    {
        $config = new Config($this->fixturesPath . '/single_config/single_config.ini');
        $config->set('test_4', 'd');
        $this->assertEquals('d', $config->get('test_4'));

        $config->set('single_config.test_5', 'e');
        $this->assertEquals('e', $config->get('test_5'));
    }

    public function testWriteToSingleFileMultipleArray()
    {
        $config = new Config($this->fixturesPath . '/single_config/single_config.ini');
        $config->set('test_6.test_a.test_b', 'e');
        $this->assertEquals('e', $config->get('test_6.test_a.test_b'));
    }

    public function testThrowingNamespaceNotFoundDuringWrite()
    {
        $this->setExpectedException('Behinddesign\Chalkboard\Exceptions\NamespaceNotFoundException');

        $config = new Config($this->fixturesPath . '/multiple_config');
        $config->set('test_write_2', 'mmm!');
        $this->assertEquals('written', $config->get('test_write_2'));
    }

    public function testWriteToMultipleFiles()
    {
        $config = new Config($this->fixturesPath . '/multiple_config');
        $config->set('config_b.low', 'low written');
        $this->assertEquals('low written', $config->get('config_b.low'));
    }

    public function testNewVariableWithMultipleFiles()
    {
        $config = new Config($this->fixturesPath . '/multiple_config');
        $config->set('config_b.middle', 'middle written');
        $this->assertEquals('middle written', $config->get('config_b.middle'));
    }
}
