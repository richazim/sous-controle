<?php

use SousControle\Core\Container;
use SousControle\Core\Request;
use SousControle\Core\RequestToControllerHandler;
use SousControle\Core\Response;
use SousControle\Core\Templating\MinimalBlade;
use SousControle\Tests\Fixtures\RequestToControllerHandler\FakeControllerToCall;
use SousControle\Tests\Fixtures\RequestToControllerHandler\FakeControllerToGetItsActionArgument;
use SousControle\Tests\Fixtures\RequestToControllerHandler\FakeControllerWithArgumentToCall;

it('calls the appropriate controller action and returns the returned response', function(){
    $controller = new FakeControllerToCall();

    $requestMock = Mockery::mock(Request::class);

    $containerMock = Mockery::mock(Container::class);
    $containerMock->shouldReceive('getInstance')->with(FakeControllerToCall::class)->andReturn($controller);

    $minimalBlade = new MinimalBlade();

    $containerMock->shouldReceive('getInstance')->with(MinimalBlade::class)->andReturn($minimalBlade);

    $requestToControllerHandler = new RequestToControllerHandler();

    $response = $requestToControllerHandler->handle(
        $requestMock,
        [
            'controller' => FakeControllerToCall::class,
            'action' => 'index'
        ],
        $containerMock
    );

    expect($response) -> toBeInstanceOf(Response::class)
    ->and($response->getHtml()) -> toBe("Hello World!");

});


it('can extract the controller action args from the params sent by the router', function(){
    $controller = new FakeControllerWithArgumentToCall();

    $requestToControllerHandler = new RequestToControllerHandler();

    // make getControllerActionArgs public method
    $method = new ReflectionMethod($requestToControllerHandler, 'getControllerActionArgs');
    $method->setAccessible(true);

    // call it
    $data = $method->invoke($requestToControllerHandler, $controller, 'index', [
        'action' => 'index',
        'controller' => FakeControllerWithArgumentToCall::class,
        'id' => '3',
        'name' => 'jon'
    ]);

    expect($data)
        ->toBe(['id' => '3']);
});