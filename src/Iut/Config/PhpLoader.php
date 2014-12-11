<?php

namespace Iut\Config;

class PhpLoader implements LoaderInterface
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
            $config = array_merge_recursive($config, include $filename);
        }

        return $config;
    }
}