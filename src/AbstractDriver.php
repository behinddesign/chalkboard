<?php namespace Behinddesign\Chalkboard;

abstract class AbstractDriver
{
    protected $rawString;
    protected $processConfig;

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
        $this->processConfig = $config;
    }

    protected function boolHandling($representation, $stringOrArray)
    {
        if (is_array($stringOrArray)) {
            array_walk_recursive($stringOrArray, function (&$val) use ($representation) {
                $val = $this->checkBool($representation, $val);
            });

            return $stringOrArray;
        }

        return $this->checkBool($representation, $stringOrArray);
    }

    private function checkBool($representation, $string)
    {
        if (!is_bool($string)) {

            $lowerCaseString = strtolower($string);

            switch ($lowerCaseString) {
                case 'true':
                    $returnVal = true;
                    break;
                case 'false':
                    $returnVal = false;
                    break;
                case $string === false;
                    $returnVal = false;
                    break;
                case $string === true:
                    $returnVal = true;
                    break;
                default:
                    return $string;
                    break;
            }
        } else {
            $returnVal = $string;
        }

        //If we find some sort of bool, lets adjust it's return based on representation.
        if ($representation == 'string') {
            return $returnVal ? 'true' : 'false';
        } else {
            return $returnVal ? true : false;
        }
    }
}
