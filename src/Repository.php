<?php namespace Behinddesign\Chalkboard;

use Behinddesign\Chalkboard\Drivers\KeyPair;
use League\Flysystem\Filesystem;

class Repository
{
    /**
     * @var Filesystem
     */
    private $filesystem;
    private $fileInfo;
    private $store;
    private $dotNotation;
    private $fileChanged = false;

    public function __construct(Filesystem $filesystem, array $fileInfo)
    {
        $this->fileInfo = $fileInfo;
        $this->filesystem = $filesystem;

        $this->read();

        $this->dotNotation = new DotNotation($this->store);
    }

    private function read()
    {
        $rawString = $this->filesystem->read($this->fileInfo['path']);

        $driver = new KeyPair($rawString);

        $this->store = $driver->read();
    }

    public function write()
    {
        //Only write if file has changed.
    }

    public function get($variable)
    {
        $ns = new FileNamespace($variable);

        return $this->dotNotation->get($ns->getSuffix());
    }

    public function set($variable, $value)
    {
        $this->fileChanged = true;

        $ns = new FileNamespace($variable);

        $this->dotNotation->set($ns->getSuffix(), $value);

        return true;
    }
}
