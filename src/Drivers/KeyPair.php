<?php namespace Behinddesign\Chalkboard\Drivers;

use Behinddesign\Chalkboard\AbstractDriver;
use Behinddesign\Chalkboard\DriverInterface;

class KeyPair extends AbstractDriver implements DriverInterface
{

    public function parse()
    {
        return parse_ini_string($this->rawString);
    }

    public function process()
    {
        return '';
    }
}
