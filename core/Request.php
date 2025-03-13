<?php

namespace SousControle\Core;

class Request
{
    public function __construct(private string $url, private string $method, private array $files, private array $post, private array $get)
    {

    }

    public function __get(string $property): mixed
    {
        if (property_exists($this, $property)) {
          return $this->$property;
        }
        return null;
    }

    public function __set(string $property, string $value) : void
    {
        if (property_exists($this, $property)) {
          $this->$property = $value;
        } 
    }
}