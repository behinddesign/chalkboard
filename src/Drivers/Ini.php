<?php namespace Behinddesign\Chalkboard\Drivers;

use Behinddesign\Chalkboard\AbstractDriver;
use Behinddesign\Chalkboard\DriverInterface;

/**
 * Class Ini
 *
 * Extract from php.net, but most libraries which can read a .ini file will adhere to these rules.
 *
 *  ; This is a sample configuration file
 *  ; Comments start with ';', as in php.ini
 *
 *  [first_section]
 *  one = 1
 *  five = 5
 *  animal = BIRD
 *
 *  [second_section]
 *  path = "/usr/local/bin"
 *  URL = "http://www.example.com/~username"
 *
 *  [third_section]
 *  phpversion[] = "5.0"
 *  phpversion[] = "5.1"
 *  phpversion[] = "5.2"
 *  phpversion[] = "5.3"
 *
 * @link http://php.net/manual/en/function.parse-ini-file.php
 * @package Behinddesign\Chalkboard\Drivers
 */
class Ini extends AbstractDriver implements DriverInterface
{
    /**
     * {@inheritdoc}
     */
    public function parse()
    {
        return parse_ini_string($this->rawString);
    }

    /**
     * {@inheritdoc}
     */
    public function process()
    {
        return '';
    }
}
