<?php namespace Behinddesign\Chalkboard;

use Behinddesign\Chalkboard\Drivers\KeyPair;
use League\Flysystem\Filesystem;

class Repository
{
    /**
     * @var Filesystem
     */
    private $filesystem;
    /**
     * @var DriverInterface
     */
    private $driver;
    private $fileInfo;
    private $store;
    private $dotNotation;
    private $fileChanged = false;

    public function __construct(Filesystem $filesystem, array $fileInfo)
    {
        $this->fileInfo = $fileInfo;
        $this->filesystem = $filesystem;

        //Remove this and replace with changeable mechanism
        $this->setDriver(new KeyPair());

        $this->read();

        $this->dotNotation = new DotNotation($this->store);
    }

    public function setDriver(DriverInterface $driver)
    {
        $this->driver = $driver;
    }

    private function read()
    {
        $rawString = $this->filesystem->read($this->fileInfo['path']);

        $this->driver->setRawString($rawString);

        $this->store = $this->driver->parse();
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

    public function __destruct()
    {
        $this->write();
    }

    public function write()
    {
        //Only write if file has changed.
        if ($this->fileChanged) {
            //Write stuff here.
        }
    }
}
