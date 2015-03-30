<?php namespace Behinddesign\Chalkboard;

abstract class AbstractDriver
{
    protected $variableString;

    public function __construct($variableString)
    {
        $this->variableString = $variableString;
    }
}
