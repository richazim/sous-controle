<?php

use SousControle\Core\ExceptionHandler;
use SousControle\Core\Exceptions\PageNotFoundException;
use SousControle\Core\HttpResponseCodeWrapper; 

it('print the correct message in development mode when a page not found exception is thrown', function(){
    $_ENV['APP_ENV'] = 'devlopmentt';

    $mockWrapper = Mockery::mock(HttpResponseCodeWrapper::class);
    $mockWrapper->shouldReceive('setCode')->once()->with(404);
    $exceptionHandler = new ExceptionHandler($mockWrapper);

    ob_start();
    $exceptionHandler->handleException(new PageNotFoundException("A Page Is Not Found"));
    $output = ob_get_clean();

    expect($output)->toContain('A Page Is Not Found');
});

it('print the correct message in development mode when other exception is thrown', function(){ 
    $_ENV['APP_ENV'] = 'devlopmentt';

    $mockWrapper = Mockery::mock(HttpResponseCodeWrapper::class);
    $mockWrapper->shouldReceive('setCode')->once()->with(500);
    $exceptionHandler = new ExceptionHandler($mockWrapper);
 
    ob_start();
    $exceptionHandler->handleException(new Exception("Something Went Wrong")); 
    $output = ob_get_clean();

    expect($output)->toContain('Something Went Wrong');
});


it('print a generic message in production mode when a page not found exception is thrown', function(){
    $_ENV['APP_ENV'] = 'production'; 
    $mockWrapper = Mockery::mock(HttpResponseCodeWrapper::class);
    $mockWrapper->shouldReceive('setCode')->once()->with(404);
    $exceptionHandler = new ExceptionHandler($mockWrapper);

    ob_start();
    $exceptionHandler->handleException(new PageNotFoundException("A Page Is Not Found"));
    $output = ob_get_clean(); 

    expect($output)->toContain('404');
});

it('print a generic message in production mode when other exception is thrown', function(){
    $_ENV['APP_ENV'] = 'production'; 

    $mockWrapper = Mockery::mock(HttpResponseCodeWrapper::class);
    $mockWrapper->shouldReceive('setCode')->once()->with(500);
    $exceptionHandler = new ExceptionHandler($mockWrapper);

    ob_start();
    $exceptionHandler->handleException(new Exception("A Page Is Not Found")); 
    $output = ob_get_clean(); 

    expect($output)->toContain('500');
});