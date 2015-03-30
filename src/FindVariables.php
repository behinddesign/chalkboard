<?php namespace Behinddesign\Chalkboard;

class FindVariables
{

    private $value;
    private $variable;
    private $variableStore;

    public function __construct($variable, $variableStore)
    {
        $this->variable = $variable;
        $this->variableStore = $variableStore;

        if (count($this->variableStore) == 1) {
            $this->value = $this->findInSingleFile();
        } else {
            $this->value = $this->findInMultipleFiles();
        }
    }

    private function findInSingleFile()
    {
        $topLevelVariables = current($this->variableStore);

        $found = $this->findDotPath($topLevelVariables);
        if (!$found) {
            $found = $this->findDotPath($this->variableStore);
        }

        return $found;
    }

    /**
     * Gracefully stolen from :
     *
     * http://stackoverflow.com/questions/2286706/php-lookup-array-contents-with-dot-syntax/2287029#2287029
     *
     * @param $context
     * @return mixed|null
     */
    private function findDotPath(&$context)
    {
        if (!strpos($this->variable, '.')) {
            if (isset($context[$this->variable])) {
                return $context[$this->variable];
            } else {
                return null;
            }
        }

        $pieces = explode('.', $this->variable);
        foreach ($pieces as $piece) {
            if (!is_array($context) || !array_key_exists($piece, $context)) {
                // error occurred
                return null;
            }
            $context = &$context[$piece];
        }

        return $context;
    }

    private function findInMultipleFiles()
    {
        return $this->findDotPath($this->variableStore);
    }

    public function value()
    {
        return $this->value;
    }
}
