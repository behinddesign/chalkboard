<?php namespace Behinddesign\Chalkboard\Drivers;

use Behinddesign\Chalkboard\AbstractDriver;
use Behinddesign\Chalkboard\DriverInterface;

/**
 * Class KeyPair
 *
 * KeyPair is a simple key = 'value' reader and writer.
 *
 * Alternative syntax versions :
 * key = value
 * key = 'value'
 * key = "value"
 * key = "value' (Eww)
 *
 * This is useful for reading and writing system environment sh files for use with "source"
 * Please use ini driver if you wish to retain multi dimensional arrays.
 *
 * NOTE : this driver will convert multi dimensional arrays to _ notation and
 * will be re-read as single dimensional arr.
 *
 * @package Behinddesign\Chalkboard\Drivers
 */
class KeyPair extends AbstractDriver implements DriverInterface
{
    /**
     * {@inheritdoc}
     */
    public function parse()
    {
        $regex = "/(?<var>[a-z0-9_]+)\\s*=\\s*(?:'|\")?(?<val>.+?)(?:'|\")?$/m";

        preg_match_all($regex, $this->rawString, $matches);

        return array_combine($matches['var'], $matches['val']);
    }

    /**
     * {@inheritdoc}
     */
    public function process()
    {
        return '';
    }
}
