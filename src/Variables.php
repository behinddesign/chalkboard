<?php namespace Behinddesign\Chalkboard;

use Behinddesign\Chalkboard\Drivers\KeyPair;
use League\Flysystem\Filesystem;

class Variables
{
    /**
     * @var Filesystem
     */
    private $filesystem;
    private $files;
    private $variables;

    public function __construct(Filesystem $filesystem, $fileData = null)
    {
        $this->filesystem = $filesystem;

        if ($fileData) {
            if (!$this->getFile($fileData)) {
                return false;
            }
        } else {
            if (!$this->getFiles()) {
                return false;
            }
        }

        $this->getVariables();

        return true;
    }

    private function getFile($fileData)
    {
        $this->files[$fileData['filename']] = array(
            'path' => $fileData['basename'],
            'filename' => $fileData['filename']
        );

        return true;
    }

    private function getFiles()
    {
        $contents = $this->filesystem->listContents();

        if (!$contents) {
            return false;
        }

        foreach ($contents as $content) {
            if ($content['type'] == 'file') {
                $this->files[$content['basename']] = $content;
            }
        }

        return true;
    }

    private function getVariables()
    {
        foreach ($this->files as &$file) {
            $variableString = $this->filesystem->read($file['path']);

            $driver = new KeyPair($variableString);
            $this->variables[$file['filename']] = $driver->read();
        }
    }

    public function find($variable)
    {
        $finder = new FindVariables($variable, $this->variables);

        return $finder->value();
    }

    public function write()
    {

    }
}
