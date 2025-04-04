<?php

use SousControle\Core\Container;
use SousControle\Core\DatabaseConnection;
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

$container->addService(DatabaseConnection::class, function(){
    return new DatabaseConnection(env('DATABASE_HOST'), env('DATABASE_NAME'), env('DATABASE_USERNAME'), env('DATABASE_PASSWORD'));
});

return $container;