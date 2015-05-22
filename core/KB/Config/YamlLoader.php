<?php

namespace KB\Config;

use Symfony\Component\Yaml\Yaml;

/**
 * Class YamlLoader
 */
class YamlLoader implements LoaderInterface
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
            $config = array_merge_recursive($config, Yaml::parse($fileName));
        }

        return $config;
    }
}