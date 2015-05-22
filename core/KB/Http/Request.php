<?php

namespace KB\Http;

/**
 * Class Request
 */
class Request
{
    /**
     * @var array
     */
    private $headers = [];

    /**
     * @var string
     */
    private $body;

    /**
     * @var string
     */
    private $method;

    /**
     * @var string
     */
    private $uri;

    /**
     * @var array
     */
    private $queries = [];

    /**
     * @param array $headers
     * @param $body
     * @param $method
     * @param $uri
     * @param array $queries
     */
    public function __construct(array $headers, $body, $method, $uri, array $queries)
    {
        $this->body = $body;
        $this->headers = $headers;
        $this->method = $method;
        $this->uri = $uri;
        $this->queries = $queries;
    }

    /**
     * @return Request
     */
    static public function createFromGlobals()
    {
        $headers = [];
        foreach ($_SERVER as $key => $value) {
            if(0 === strpos($key, 'HTTP')){
                $normalizedHeaderName = substr($key, 5);
                $normalizedHeaderName = str_replace('_', '-', $normalizedHeaderName);
                $normalizedHeaderName = strtolower($normalizedHeaderName);
                $headers[] = new Header($normalizedHeaderName, $value);
            }
        }

        $body = file_get_contents('php://input');

        $method = $_SERVER['REQUEST_METHOD'];

        $uri = $_SERVER['REQUEST_URI'];

        $rawQuery = isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : '';

        parse_str($rawQuery, $query);

        return new self(
            $headers,
            $body,
            $method,
            $uri,
            $query
        );
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @param $name
     * @return mixed
     */
    public function getHeader($name)
    {
        /** @var Header $header */
        foreach($this->headers as $header){
            if($header->getName() === $name){

                return $name;
            }
        }
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
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
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        $url = explode('?', $this->uri);
        return $url[0];
    }

    /**
     * @return mixed
     */
    public function getQueries()
    {
        return $this->queries;
    }

    /**
     * @param $paramName
     * @return null
     */
    public function getQueryParam($paramName)
    {
        return isset($this->queries[$paramName]) ? $this->queries[$paramName] : null;
    }
}