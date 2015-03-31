<?php namespace Behinddesign\Chalkboard;

abstract class AbstractDriver
{
    protected $rawString;

    public function __construct($rawString = null)
    {
        if ($rawString) {
            $this->setRawString($rawString);
        }
    }

    public function setRawString($string)
    {
        $this->rawString = $string;
    }
}
