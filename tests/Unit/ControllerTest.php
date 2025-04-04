<?php

use SousControle\Core\Response;
use SousControle\Core\Templating\MinimalBlade;
use SousControle\Tests\Fixtures\RequestToControllerHandler\FakeControllerToCall;
use SousControle\Tests\Fixtures\RequestToControllerHandler\FakeControllerWithArgumentToCall;

it('renders a views with the appropriate data', function(){
    $controller = new FakeControllerToCall();
    
    $response = new Response();
    $controller->setResponse($response);
    $templateViewerMock = Mockery::mock(MinimalBlade::class);
    $templateViewerMock->shouldReceive('process')->withAnyArgs()->andReturn('Hello Jon');
    $controller->setTemplateViewer($templateViewerMock);

    $response = $controller->view('home/index', ['name' => 'jon']);

    expect($response)->toBeInstanceOf(Response::class)
    ->and($response->getHtml()) -> toBe('Hello Jon');
});