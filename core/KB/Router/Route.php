<?php

namespace KB\Router;

/**
 * Class Route
 */
class Route
{
    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $method;

    /**
     * @var string
     */
    private $action;

    /**
     * @param $url
     * @param $method
     * @param $action
     */
    public function __construct($url, $method, $action)
    {
        $this->url = $url;
        $this->method = $method;
        $this->action = $action;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }
} 