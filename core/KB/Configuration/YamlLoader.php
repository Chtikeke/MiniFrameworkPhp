<?php

namespace KB\Configuration;

use Symfony\Component\Yaml\Yaml;

/**
 * Class YamlLoader
 */
class YamlLoader implements LoaderInterface
{
    /**
     * @var array
     */
    private $filenames = [];

    /**
     * @param array $filenames
     */
    public function __construct(array $filenames)
    {
        $this->filenames = $filenames;
    }

    /**
     * @return array
     */
    public function load()
    {
        $config = [];

        foreach ($this->filenames as $filename) {
            $config = array_merge_recursive($config, Yaml::parse($filename));
        }

        return $config;
    }
}