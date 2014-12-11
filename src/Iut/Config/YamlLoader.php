<?php

namespace Iut\Config;

use Symfony\Component\Yaml\Yaml;

class YamlLoader implements LoaderInterface
{
    private $filenames;

    public function __construct(array $filenames)
    {
        $this->filenames = $filenames;
    }

    public function load()
    {
        $config = [];
        foreach ($this->filenames as $filename) {
            $config = array_merge_recursive($config, Yaml::parse($filename));
        }

        return $config;
    }
}