<?php

use SousControle\Core\Container;
use SousControle\Core\Middlewares\Middleware;
use SousControle\Core\Middlewares\Pipeline;
use SousControle\Core\Request;
use SousControle\Core\Response;
use SousControle\Tests\Fixtures\Middlewares\MiddlewareOne;
use SousControle\Tests\Fixtures\Middlewares\MiddlewareThree;
use SousControle\Tests\Fixtures\Middlewares\MiddlewareTwo;
use SousControle\Tests\Fixtures\Middlewares\SecondAuthMiddleware;
use SousControle\Tests\Fixtures\Middlewares\SimpleMiddleware;
use SousControle\Tests\Fixtures\Pipeline\Controller;
use SousControle\Tests\Fixtures\Pipeline\ControllerTest;

beforeEach(function(){
    $this->request = new Request('/test');
    $this->container = new Container();
});

test('Pipeline executes the controller when no middleware', function(){
    $controller = new Controller();

    $this->container->addService(Controller::class, fn() => $controller);

    $pipeline = new Pipeline($this->request, [
        'middlewares' => [SimpleMiddleware::class], 
        'controller' => ControllerTest::class, 'action' => 'index'
    ], $this->container);

    $response = $pipeline->getResponse();

    expect($response)
        ->toBeInstanceOf(Response::class)
        ->and($response->getHtml())->toBe('OK')
        ->and($response->getStatus())->toBe(200);
});

test('Pipeline executes a middleware before the controller', function(){
    $middleware = new SecondAuthMiddleware();

    $controller = new Controller();

    $this->container->addService(SecondAuthMiddleware::class, fn() => $middleware);
    $this->container->addService(Controller::class, fn() => $controller);

    $pipeline = new Pipeline($this->request, [
        'controller' => Controller::class,
        'action' => 'index',
        'middlewares' => [SecondAuthMiddleware::class]
    ], $this->container);

    $response = $pipeline->getResponse();

    expect($response)
        ->toBeInstanceOf(Response::class)
        ->and($response->getHtml())
        ->toBe('Unauthorized')
        ->and($response->getStatus())
        ->toBe(401);
});

test('Pipeline executes multiple middlewares in order', function(){
    $middleware1 = new MiddlewareOne();
    $middleware2 = new MiddlewareTwo();
    $middleware3 = new MiddlewareThree();

    $this->container->addService(MiddlewareOne::class, fn() => $middleware1);
    $this->container->addService(MiddlewareTwo::class, fn() => $middleware2);
    $this->container->addService(MiddlewareThree::class, fn() => $middleware3);

    $pipeline = new Pipeline($this->request, [
        'controller' => ControllerTest::class,
        'action' => 'index',
        'middlewares' => [MiddlewareOne::class, MiddlewareTwo::class, MiddlewareThree::class]
    ], $this->container);

    $response = $pipeline->getResponse();

    expect($response)
        ->toBeInstanceOf(Response::class)
        ->and($response->getHtml())
        ->toBe('OK - MiddlewareThree - MiddlewareTwo - MiddlewareOne')
        ->and($response->getStatus())
        ->toBe(200);
});