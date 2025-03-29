<?php

use SousControle\Core\Exceptions\RouteNotFoundException;
use SousControle\Core\Request;
use SousControle\Core\Router;

beforeEach(function () {
    $this->router = new Router();
});

it('can add a route correctly with route url only', function(){ 
    $this->router->add('/', [], []);
    
    expect($this->router)->toHaveProperty('routes')
        ->and($this->router->getRoutes()[0])
        ->toBe([
            "urlMethodPair" => ["url" => "/", "method" => "GET"],
            "paramsArray" => [],
            "middlewares" => ["middlewares" => []]
        ]); 
});

it('can add a route correctly with route urlMethodPair as an array', function(){ 
    $this->router->add(['url' => '/', 'method' => 'POST'], [], []);
    
    expect($this->router)->toHaveProperty('routes')
        ->and($this->router->getRoutes()[0])
        ->toBe([
            "urlMethodPair" => ["url" => "/", "method" => "POST"],
            "paramsArray" => [],
            "middlewares" => ["middlewares" => []]
        ]); 
});


it('convert route url to regex pattern correctly', function(){
    $reflection = new ReflectionClass($this->router);
    $method = $reflection->getMethod('transformRouteUrlToPattern');
    $method->setAccessible(true);

    $pattern = $method->invoke($this->router, '/'); 
    expect($pattern)->toBe("#^$#iu");

    $pattern = $method->invoke($this->router, '/home'); 
    expect($pattern)->toBe("#^home$#iu");

    $pattern = $method->invoke($this->router, '/{controller}/{action}'); 
    expect($pattern)->toBe("#^(?<controller>[^/]+)/(?<action>[^/]+)$#iu");

    $pattern = $method->invoke($this->router, '/post/{slug:[a-z0-9-]+}'); 
    expect($pattern)->toBe("#^post/(?<slug>[a-z0-9-]+)$#iu");
});


it('match a request to a route correctly', function(){
    $this->router->add('/user/{id:\d+}', ['controller' => 'UserController', 'action' => 'show']);

    $request = new Request(url: '/user/42', method: 'GET');
    $matchedRoute = $this->router->match($request);

    expect($matchedRoute)->toHaveKeys(['id', 'controller', 'action', 'method'])
        ->and($matchedRoute['id'])->toBe('42')
        ->and($matchedRoute['controller'])->toBe('UserController')
        ->and($matchedRoute['action'])->toBe('show')
        ->and($matchedRoute['method'])->toBe('GET');
});


it('throws an exception if route not found', function(){
    $this->router->add('/profile', ['controller' => 'ProfileController', 'action' => 'view']);

    $request = new Request(url: '/dashboard', method: 'GET');

    expect(fn() => $this->router->match($request))->toThrow(RouteNotFoundException::class);
});