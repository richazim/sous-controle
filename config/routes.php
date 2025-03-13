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

// $route->add([
//     'url' => '/users',
//     'method' => 'GET'
// ], [
//     'controller' => 'users',
//     'action' => 'index'
// ], [
//     'middleware' => 'auth'
// ]);

// $route->add([
//     'url' => '/{controller}/{action}',
//     'method' => 'GET'
// ]);

$route->add([
    'url' => '/{controller}/{action}',
    'method' => 'GET'
],
[

], [
    'middleware' => 'auth'
]);


return $route;