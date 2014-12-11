<?php

namespace Iut\Http;


class Response
{
    private $statusCode;
    private $body;
    private $headers = [];

    public function __construct($statusCode = 200, $body = '', array $headers = [])
    {
        $this->statusCode = (int) $statusCode;
        $this->body = $body;
        $this->headers = $headers;
    }

    // On met des getters car la réponse peut être travaillé par quelqu'un d'autre
    public function getBody()
    {
        return $this->body;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function send()
    {
        http_response_code($this->statusCode);

        foreach($this->headers as $header)
        {
            header($header);
        }
        echo $this->body;
    }
} 