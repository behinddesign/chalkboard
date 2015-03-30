<?php namespace Behinddesign\Chalkboard\Drivers;

use Behinddesign\Chalkboard\AbstractDriver;
use Behinddesign\Chalkboard\DriverInterface;

class KeyPair extends AbstractDriver implements DriverInterface
{

    public function read()
    {
        return parse_ini_string($this->variableString);
    }

    public function write()
    {
        return '';
    }
}
