<?php

namespace KB\Configuration;

/**
 * Class Configuration
 */
class Configuration
{
    /**
     * @var LoaderInterface
     */
    private $loader;

    /**
     * @var array
     */
    private $config;

    /**
     * @param LoaderInterface $loader
     */
    public function __construct(LoaderInterface $loader)
    {
        $this->loader = $loader;
    }

    /**
     * @param $section
     * @return mixed
     * @throws \Exception
     */
    public function getSection($section)
    {
        if (!$this->config) {
           $this->config = $this->loader->load();
        }

        if (!isset($this->config[$section])) {
            throw new \Exception(sprintf('Section "%s" not found', $section));
        }

        return $this->config[$section];
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }
}