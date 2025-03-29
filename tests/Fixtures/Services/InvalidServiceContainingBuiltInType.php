<?php

namespace SousControle\Tests\Fixtures\Services;

class InvalidServiceContainingBuiltInType
{
    public function __construct(int $value)
    {
        
    }
}