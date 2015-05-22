<?php

namespace KB\Http;

/**
 * Class Response
 */
class Response
{
    /**
     * @var int
     */
    private $statusCode;

    /**
     * @var string
     */
    private $body;

    /**
     * @var array
     */
    private $headers = [];

    /**
     * @param int $statusCode
     * @param string $body
     * @param array $headers
     */
    public function __construct($statusCode = 200, $body = '', array $headers = [])
    {
        $this->statusCode = (int) $statusCode;
        $this->body = $body;
        $this->headers = $headers;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function send()
    {
        http_response_code($this->statusCode);

        foreach ($this->headers as $header) {
            header($header);
        }

        echo $this->body;
    }
} 