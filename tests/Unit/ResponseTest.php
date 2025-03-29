<?php

use SousControle\Core\Response;

test('constructor initializes response correctly', function(){
    $response = new Response("<h1>Hello</h1>", 201, ['Content-Type' => 'text/html']);

    expect($response->getHtml())->toBe("<h1>Hello</h1>")
        ->and($response->getStatus())->toBe(201)
        ->and($response->getHeaders())->toBe(['Content-Type' => 'text/html']);
});

test('setHtml updates content', function () {
    $response = new Response();
    $response->setHtml("Updated content");

    expect($response->getHtml())->toBe("Updated content");
});

test('setStatus updates HTTP status', function () {
    $response = new Response();
    $response->setStatus(404);

    expect($response->getStatus())->toBe(404);
});

test('setHeader stores headers correctly', function () {
    $response = new Response();
    $response->setHeader("X-Custom-Header", "Value");

    expect($response->getHeaders())->toHaveKey("X-Custom-Header")
        ->and($response->getHeaders()["X-Custom-Header"])->toBe("Value");
});


it('set a correct json response with its header and body', function () {
    $response = new Response();
    $response->json(["message" => "success"], 201);

    expect($response->getStatus())->toBe(201)
        ->and($response->getHeaders()["Content-Type"])->toBe('application/json')
        ->and($response->getHtml())->toBe(json_encode(["message" => "success"]));
});


it('output correct content', function(){
    $response = new Response("<h1>Hello</h1>", 201, ['Content-Type' => 'text/html']);
    ob_start();
    $response->respond();
    $output = ob_get_clean(); 

    expect($output)->toBe("<h1>Hello</h1>");
});