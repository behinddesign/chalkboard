<?php namespace Behinddesign\Chalkboard\Drivers;

use Behinddesign\Chalkboard\AbstractDriver;
use Behinddesign\Chalkboard\DriverInterface;
use Behinddesign\Chalkboard\Exceptions\ArrayNotExpectedException;

/**
 * Class DotEnv
 *
 * DotEnv is a simple KEV=value reader and writer.
 *
 * Alternative read syntax versions :
 * key = value
 * key = 'value'
 * key = "value"
 * key = "value' (Eww)
 *
 * Write syntax :
 * KEY=value
 *
 * This is useful for reading and writing system environment sh files for use with "source"
 * Please use ini driver if you wish to retain multi dimensional arrays.
 *
 * NOTE : this driver will not store multidimensional arrays, and will strip out any comments.
 *
 * @package Behinddesign\Chalkboard\Drivers
 */
class DotEnv extends AbstractDriver implements DriverInterface
{
    protected $registerExtensionHandling = [
        'env',
        'sh'
    ];

    /**
     * {@inheritdoc}
     */
    public function parse()
    {
        $regex = "/(?<var>[a-z0-9_]+)\\s*=\\s*(?:'|\")?(?<val>.+?)(?:'|\")?$/mi";

        preg_match_all($regex, $this->rawString, $matches);

        return array_combine($matches['var'], $this->boolHandling('bool', $matches['val']));
    }

    /**
     * {@inheritdoc}
     */
    public function process()
    {
        if (empty($this->processConfig)) {
            return '';
        }

        $lines = '';
        foreach ($this->processConfig as $key => $val) {
            if (is_array($val)) {
                throw new ArrayNotExpectedException($key . '\'s value should not be an array. DotEnv driver does not ' .
                    'support multiple dimension arrays.');
            }
            $lines .= $key . '=' . $this->boolHandling('string', $val) . "\n";
        }

        $lines = trim($lines);

        return $lines;
    }
}
