<?php

use SousControle\Core\Exceptions\Container;
use SousControle\Core\Response;

$container = new Container();

$container->addService(Response::class, function (){
    return new Response();
});

return $container;