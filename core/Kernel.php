<?php

namespace SousControle\Core;

use SousControle\Core\Container;
use SousControle\Core\Middlewares\Pipeline;
use SousControle\Core\Request;
use SousControle\Core\Response;
use SousControle\Core\Router;

class Kernel
{
    private Pipeline $pipeline;

    public function __construct(private Request $request, private Router $router, private Container $container)
    {
        $params = $this->router->match($request); 
        $this->pipeline = new Pipeline($request,  $params, $container);
    }

    public function getResponse(): Response
    { 
        return $this->pipeline->getResponse();
    }
}