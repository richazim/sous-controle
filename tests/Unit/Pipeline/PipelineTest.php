<?php

use SousControle\Core\Container;
use SousControle\Core\Middlewares\Pipeline;
use SousControle\Core\Request;
use SousControle\Core\RequestToControllerHandler;
use SousControle\Core\Response;
use SousControle\Tests\Fixtures\Middlewares\SimpleMiddleware;
use SousControle\Tests\Fixtures\Pipeline\Controller;

function getMockInstance($className) 
{
    $mock = \Mockery::mock($className); 
    return $mock;
}

it('executes a middleware before the controller', function () {
    $request = Mockery::mock(Request::class);
    
    $middleware = Mockery::mock(SimpleMiddleware::class);

    $container = Mockery::mock(Container::class); 

    $container
        ->shouldReceive('getInstance')
        ->with(SimpleMiddleware::class)
        ->once()
        ->andReturn($middleware);
        
    $container
        ->shouldReceive('getInstance')
        ->with('Home')
        ->never()
        ->andReturn(new Response('<p>Hello World!</p> : From Home Controller'));

    $pipeline = new Pipeline( 
        $request, 
    ['middlewares' => [SimpleMiddleware::class], 'controller' => 'Home', 'action' => 'index'],
            $container
    );

    $middleware
        ->shouldReceive('handle')
        ->once()
        ->withAnyArgs()
        ->andReturn(new Response('<p>Hello World</p>: From SimpleMiddleware')); 

    $response = $pipeline->getResponse();

    expect($response)->toBeInstanceOf(Response::class)
        ->and($response->getHtml())->toBe('<p>Hello World</p>: From SimpleMiddleware');
});

it('executes the controller when no middleware', function(){
    $request = Mockery::mock(Request::class);

    $response = Mockery::mock(Response::class);
    
    $handler = Mockery::mock(RequestToControllerHandler::class);
    $handler
        ->shouldReceive('handle')
        ->times(3)
        ->andReturn(new Response('OK', 200));

    $container = Mockery::mock(Container::class); 

    $container
        ->shouldReceive('getInstance')
        ->with(RequestToControllerHandler::class) 
        ->times(3)
        ->andReturn($handler);

    $pipeline = new Pipeline( 
        $request, 
    ['middlewares' => [], 'controller' => Controller::class, 'action' => 'index'],
            $container
    );

    expect($pipeline->getResponse())
        ->toBeInstanceOf(Response::class)
        ->and($pipeline->getResponse()->getHtml())->toBe('OK')
        ->and($pipeline->getResponse()->getStatus())->toBe(200);
});