<?php

use phpmock\MockBuilder;
use SousControle\Core\Request;
use SousControle\Core\Response;
use SousControle\Tests\Fixtures\Auth\Auth;
use SousControle\Tests\Fixtures\Middlewares\AuthMiddleware;
use SousControle\Tests\Fixtures\Middlewares\SimpleMiddleware; 

it('can sends a request to the pipeline closure and gets a response from it', function () {
    $request = Mockery::mock(Request::class); 
    
    $next = fn($request) => new Response('<p>Hello World</p>');

    $simpleMiddleware = new SimpleMiddleware();

    $response = $simpleMiddleware->handle($request, $next);

    expect($response)->toBeInstanceOf(Response::class)
        ->and($response->getHtml())->toBe('<p>Hello World</p>');
}); 

it('can send a request to the pipeline closure only for authenticated users', function(){
    $request = Mockery::mock(Request::class);

    $next = fn($request) => new Response('<p>Hello Authenticated User!</p>'); 

    $builder = new MockBuilder();
    $builder->setNamespace("SousControle\Tests\Fixtures\Middlewares")
            ->setName("time")
            ->setFunction(
                function () { // to simulate isAuthenticated function
                    return 0;
                }
            ); 
    $mock = $builder->build();
    $mock->enable();

    $authMiddleware = new AuthMiddleware(); 

    $response = $authMiddleware->handle($request, $next);

    expect($response)->toBeInstanceOf(Response::class)
        ->and($response->getHtml())->toBe('Unauthorized')
        ->and($response->getStatus())->toBe(401);
});