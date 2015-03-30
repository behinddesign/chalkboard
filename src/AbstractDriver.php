<?php namespace Behinddesign\Chalkboard;

abstract class AbstractDriver
{
    protected $rawString;

    public function __construct($rawString)
    {
        $this->rawString = $rawString;
    }
}
