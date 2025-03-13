<?php

namespace SousControle\Core\Exceptions;

use Closure;

class Container
{
    private array $container = [];

    public function addService(string $className, Closure $closure): void
    {
        $this->container[$className] = $closure;
    }

    public function getInstance(string $className): mixed
    {
        if(array_key_exists($className, $this->container)){
            return $this->container[$className]();
        }

        
    }
}