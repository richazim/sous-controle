<?php

use SousControle\Core\Request;

beforeEach(function () {
    $this->request = new Request(
        url: '/home',
        method: 'GET',
        files: ['file1' => 'image.jpg'],
        post: ['name' => 'John'],
        get: ['id' => '123']
    );
});


it('initialize properties with default values', function(){
    $request = new Request();
    expect($request->getUrl())->toBe('')
        ->and($request->getMethod())->toBe('')
        ->and($request->getFiles())->toBe([])
        ->and($request->getPost())->toBe([])
        ->and($request->getGet())->toBe([]);
});

it('initialize properties correctly', function () {
    expect($this->request->getUrl())->toBe('/home')
        ->and($this->request->getMethod())->toBe('GET')
        ->and($this->request->getFiles())->toBe(['file1' => 'image.jpg'])
        ->and($this->request->getPost())->toBe(['name' => 'John'])
        ->and($this->request->getGet())->toBe(['id' => '123']);
});

it('create a request from globals', function(){
    $_SERVER['REQUEST_URI'] = '/dashboard';
    $_SERVER['REQUEST_METHOD'] = 'GET';
    $_FILES = ['avatar' => 'profile.jpg'];
    $_POST = ['email' => 'test@example.com'];
    $_GET = ['page' => '1'];

    $request = Request::createFromGlobals(); 

    expect($request)->toBeInstanceOf(Request::class)
        ->and($request->getUrl())->toBe('/dashboard')
        ->and($request->getMethod())->toBe('GET')
        ->and($request->getFiles())->toBe(['avatar' => 'profile.jpg'])
        ->and($request->getPost())->toBe(['email' => 'test@example.com'])
        ->and($request->getGet())->toBe(['page' => '1']);
});

