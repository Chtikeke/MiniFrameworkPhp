<?php

namespace KB\Config;

/**
 * Class PhpLoader
 */
class PhpLoader implements LoaderInterface
{
    /**
     * @var array
     */
    private $fileNames;

    /**
     * @param array $fileNames
     */
    public function __construct(array $fileNames)
    {
        $this->$fileNames = $fileNames;
    }

    /**
     * @return array
     */
    public function load()
    {
        $config = [];
        foreach ($this->$fileNames as $fileName) {
            $config = array_merge_recursive($config, include $fileName);
        }

        return $config;
    }
}