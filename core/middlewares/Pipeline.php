<?php

namespace SousControle\Core\Middlewares;

use SousControle\Core\Request;
use SousControle\Core\Response;

class Pipeline
{
    public function __construct(private array $middlewares, private Request $request)
    {
        
    }

    public function getResponse(): Response
    {

    }
}