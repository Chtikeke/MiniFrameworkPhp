<?php

namespace Iut\Config;

class Configuration
{
    private $loader;
    private $config;

    public function __construct(LoaderInterface $loader)
    {
        $this->loader = $loader;
    }

    public function getSection($section)
    {
        if(!$this->config){
           $this->config = $this->loader->load(); // lazy loading : charger uniquement au moment où on en a besoin. Système de cache
        }

        if(!isset($this->config[$section])){
            throw new \Exception(sprintf('Section "%s" not found', $section));
        }

        return $this->config[$section];
    }
}