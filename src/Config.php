<?php namespace Behinddesign\Chalkboard;

use Behinddesign\Chalkboard\Exceptions\NamespaceNotFoundException;
use League\Flysystem\Adapter\Local;
use League\Flysystem\AdapterInterface;
use League\Flysystem\Filesystem;

class Config
{
    /**
     * @var Repository[];
     */
    private $repositories;
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
    }

    private function setAdapter(AdapterInterface $adapterInterface)
    {
        $this->filesystemAdapter = $adapterInterface;
    }

    private function setFileSystem()
    {
        $this->filesystem = new Filesystem($this->filesystemAdapter);

        $contents = $this->filesystem->listContents();

        foreach ($contents as $content) {
            $this->repositories[$content['filename']] = new Repository($this->filesystem, $content);
        }
    }

    public function set($name, $value)
    {
        if (count($this->repositories) == 1) {
            $first = current($this->repositories);

            return $first->set($name, $value);
        }

        $ns = new FileNamespace($name);

        if (!isset($this->repositories[$ns->getPrefix()])) {
            throw new NamespaceNotFoundException('Cannot find the prefixed namespace used for this config->set - ' . $ns->getPrefix());
        }

        return $this->repositories[$ns->getPrefix()]->set($name, $value);
    }

    public function get($name)
    {
        if (count($this->repositories) == 1) {
            $first = current($this->repositories);

            return $first->get($name);
        }

        $ns = new FileNamespace($name);

        if (!isset($this->repositories[$ns->getPrefix()])) {
            throw new NamespaceNotFoundException('Cannot find the prefixed namespace used for this config->get - ' . $ns->getPrefix());
        }

        return $this->repositories[$ns->getPrefix()]->get($name);
    }
}
