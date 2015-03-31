<?php namespace Behinddesign\Chalkboard;

abstract class AbstractDriver
{
    protected $rawString;

    public function __construct($rawString = null)
    {
        if ($rawString) {
            $this->setParseConfig($rawString);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setParseConfig($config)
    {
        $this->rawString = $config;
    }

    /**
     * {@inheritdoc}
     */
    public function setProcessConfig($config)
    {

    }
}
