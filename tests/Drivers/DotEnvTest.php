<?php

use Behinddesign\Chalkboard\Drivers\DotEnv;

class DotEnvTest extends PHPUnit_Framework_TestCase
{
    private $simpleTestRawString =
        "TEST1=this\nTEST2=that\nTEST3=other\nTEST4=false\nTEST5=true\ntest6=more\ntESt7=mixed\ntest_number_9=underscores!";
    private $simpleTestResultArray = [
        'TEST1' => 'this',
        'TEST2' => 'that',
        'TEST3' => 'other',
        'TEST4' => false,
        'TEST5' => true,
        'test6' => 'more',
        'tESt7' => 'mixed',
        'test_number_9' => 'underscores!'
    ];

    public function testParseStringToArray()
    {
        $driver = new DotEnv();
        $driver->setParseConfig($this->simpleTestRawString);
        $driver->setProcessConfig($this->simpleTestResultArray);

        $this->assertEquals($driver->parse(), $this->simpleTestResultArray);
        $this->assertEquals($driver->process(), $this->simpleTestRawString);
    }
}
