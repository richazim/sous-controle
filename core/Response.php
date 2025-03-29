<?php

namespace SousControle\Core;

class Response
{
    private string $html;
    private int $status;
    private array $headers;

    public function __construct(string $html = '', int $status = 200, array $headers = [])
    {
        $this->html = $html;
        $this->status = $status;
        $this->headers = $headers;
    }

    public function getHtml(): string
    {
        return $this->html;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    } 

    public function setHtml(string $html): void
    {
        $this->html = $html;
    }

    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    public function setHeader(string $name, string $value): void
    {
        $this->headers[$name] = $value;
    }

    public function json(array $data, int $status = 200): void
    {
        $this->setHeader('Content-Type', 'application/json');
        $this->setStatus($status);
        $this->setHtml(json_encode($data));
    }

    public function respond(): void
    {
        if ($this->getStatus()) {
        
            http_response_code($this->status);
        }

        foreach ($this->getHeaders() as $name => $value) {
            header("$name: $value");
        }

        echo $this->getHtml();
    }
}