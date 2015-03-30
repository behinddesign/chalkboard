<?php namespace Behinddesign\Chalkboard;

use League\Flysystem\Adapter\Local;
use League\Flysystem\AdapterInterface;
use League\Flysystem\Filesystem;

class Config
{
    /**
     * @var Variables;
     */
    private $variables;
    private $fileData;
    private $filesystem;
    private $filesystemAdapter;

    public function __construct($directoryOrAdapter = null)
    {
        if ($directoryOrAdapter) {
            $this->setDirectoryOrAdapter($directoryOrAdapter);
        }
    }

    public function setDirectoryOrAdapter($FileDirectoryOrAdapter)
    {
        if ($FileDirectoryOrAdapter instanceof AdapterInterface) {
            $this->setAdapter($FileDirectoryOrAdapter);
        } elseif (!empty($FileDirectoryOrAdapter)) {
            //Directory or is set, but no adapter, lets just assume local.
            if (is_dir($FileDirectoryOrAdapter)) {
                //Path is a directory
                $adapter = new Local($FileDirectoryOrAdapter);
            } else {
                //Path is a file, lets load just this file.
                $pathInfo = pathinfo($FileDirectoryOrAdapter);
                $adapter = new Local($pathInfo['dirname']);
                $this->fileData = $pathInfo;
            }

            $this->setAdapter($adapter);
        }

        $this->setFileSystem();
        $this->variables = new Variables($this->filesystem, $this->fileData);
    }

    private function setAdapter(AdapterInterface $adapterInterface)
    {
        $this->filesystemAdapter = $adapterInterface;
    }

    private function setFileSystem()
    {
        $this->filesystem = new Filesystem($this->filesystemAdapter);
    }

    public function write()
    {

    }

    public function get($name)
    {
        return $this->variables->find($name);
    }
}
