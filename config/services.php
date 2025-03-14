<?php

use SousControle\Core\Container;
use SousControle\Core\Response;
use SousControle\Core\Templating\MinimalBlade;
use SousControle\Core\Templating\TemplatingEngine;

$container = new Container();

$container->addService(Response::class, function (){
    return new Response();
});

$container->addService(TemplatingEngine::class, function(){
    return new MinimalBlade();
});

return $container;