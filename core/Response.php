<?php

namespace SousControle\Core;

class Response
{
    private string $html = '';
    private int $status = 200;
    private array $headers = [];

    public function __construct()
    {

    }

    public function __get(string $property): mixed
    {
        if (property_exists($this, $property)) {
          return $this->$property;
        }
        return null;
    }

    public function setHtml(string $html): void
    {
        $this->html = $html;
    }

    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    public function setHeader(string $header): void
    {
        $this->headers[] = $header;
    }

    public function respond(): void
    {
        if ($this->__get('status')) {
        
            http_response_code($this->status);
        }

        foreach ($this->__get('headers') as $header) {
            header($header);
        }

        echo $this->__get('html');
    }
}