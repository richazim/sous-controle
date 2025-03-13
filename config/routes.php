<?php

use SousControle\Core\Route;

$route = new Route();

$route->add([
    'url' => '/',
    'method' => 'GET'
], [
    'controller' => 'home',
    'action' => 'index'
], [
    'middleware' => 'auth'
]);


return $route;