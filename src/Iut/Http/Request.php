<?php
namespace Iut\Http;

class Request
{
    private $headers = [];
    private $body;
    private $method;
    private $uri;
    private $query = [];

    public function __construct($headers, $body, $method, $uri, $query)
    {
        $this->body = $body;
        $this->headers = $headers;
        $this->method = $method;
        $this->uri = $uri;
        $this->query = $query;
    }

    // Méthode utilitaire. Pattern : Factory
    static public function createFromGlobals()
    {
        $headers = [];
        foreach($_SERVER as $key => $value){
            if(0 === strpos($key, 'HTTP')){
                $normalizedHeaderName = substr($key, 5);
                $normalizedHeaderName = str_replace(
                    '_',
                    '-',
                    $normalizedHeaderName
                );
                $normalizedHeaderName = strtolower($normalizedHeaderName);
                $headers[] = new Header($normalizedHeaderName, $value);
            }
        }

        $body = file_get_contents('php://input');

        $method = $_SERVER['REQUEST_METHOD'];

        $uri = $_SERVER['REQUEST_URI'];

        $rawQuery = isset($_SERVER['QUERY_STRING'])
            ? $_SERVER['QUERY_STRING']
            : ''
        ;

        parse_str($rawQuery, $query);

        $request = new self(
            $headers,
            $body,
            $method,
            $uri,
            $query
        );

        // On retourne l'objet
        return $request;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function getHeader($name)
    {
         foreach($this->headers as $header){
            if($header->getName() === $name){

                return $name;
            }
        }
    }

    public function getBody()
    {
        return $this->body;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function getQuery()
    {
        return $this->query;
    }

    public function getQueryParam($paramName)
    {
        return isset($this->query[$paramName])
            ? $this->query[$paramName]
            : null;
    }
}