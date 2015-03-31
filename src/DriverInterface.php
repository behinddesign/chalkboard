<?php namespace Behinddesign\Chalkboard;

interface DriverInterface
{
    public function parse();

    public function process();

    public function setRawString($string);
}
