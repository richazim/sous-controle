<?php

namespace SousControle\Tests\Fixtures\Services;

use SousControle\Tests\Fixtures\Services\ServiceB;

class InvalidServiceContainingDoubleTypes
{
    public function __construct(ServiceA | ServiceB $service)
    {
        
    }
}