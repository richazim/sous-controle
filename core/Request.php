<?php

namespace SousControle\Core;

use SousControle\Core\Exceptions\InvalidCallException;

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
        throw new InvalidCallException("Property $property does not exist on class " . static::class);
    }

    public function __set(string $property, string|array $value) : void
    {
        if (property_exists($this, $property)) {
          $this->$property = $value;
        } 
    }
}