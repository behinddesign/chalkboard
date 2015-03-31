<?php namespace Behinddesign\Chalkboard;

class FileNamespace
{
    private $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getPrefix()
    {
        $dotLocation = strpos($this->name, '.');
        if ($dotLocation === false) {
            return $this->name;
        }

        return substr($this->name, 0, $dotLocation);
    }

    public function getSuffix()
    {
        $dotLocation = strpos($this->name, '.');
        if ($dotLocation === false) {
            return $this->name;
        }

        return substr($this->name, $dotLocation + 1);
    }
}
