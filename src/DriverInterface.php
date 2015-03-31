<?php namespace Behinddesign\Chalkboard;

interface DriverInterface
{
    /**
     * Parses the string specified in the abstract classes method 'setRawString'
     *
     * @return array
     */
    public function parse();

    /**
     * Processes an array of configuration values and stores them after being processed
     *
     * @return string
     */
    public function process();


    /**
     * Set the config to be parsed, string of configuration values
     *
     * @param string $parseConfig
     * @return null
     */
    public function setParseConfig($parseConfig);


    /**
     * Set the config to be processed, array of configuration values
     *
     * @param $processConfig
     * @return null
     */
    public function setProcessConfig($processConfig);
}
