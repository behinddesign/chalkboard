<?php namespace Behinddesign\Chalkboard;

use Behinddesign\Chalkboard\Drivers\DotEnv;
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
        $this->setDriver(new DotEnv());

        $this->read();

        $this->dotNotation = new DotNotation($this->store);
    }

    public function setDriver(DriverInterface $driver)
    {
        $this->driver = $driver;
    }

    public function read()
    {
        $rawString = $this->filesystem->read($this->fileInfo['path']);

        $this->driver->setParseConfig($rawString);

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

            $this->driver->setProcessConfig($this->dotNotation->getValues());

            $rawString = $this->driver->process();

            $this->filesystem->update($this->fileInfo['path'], $rawString);
        }
    }
}
