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
        $removedNamespaceVariables = current($this->variableStore);

        $dotPath = new DotNotation($removedNamespaceVariables);
        $found = $dotPath->get($this->variable);
        if (!$found) {
            $dotPath = new DotNotation($this->variableStore);
            $found = $dotPath->get($this->variable);
        }

        return $found;
    }

    private function findInMultipleFiles()
    {
        $dotPath = new DotNotation($this->variableStore);

        return $dotPath->get($this->variable);
    }

    public function value()
    {
        return $this->value;
    }
}
