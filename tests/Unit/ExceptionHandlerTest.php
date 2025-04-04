<?php

use SousControle\Core\DataPrinterWrapper;
use SousControle\Core\ExceptionHandler;
use SousControle\Core\Exceptions\PageNotFoundException;
use SousControle\Core\HttpResponseCodeWrapper; 

it('print the correct message in development mode when a page not found exception is thrown', function(){
    $_ENV['APP_ENV'] = 'development';

    $httpResponseCodeCallerMock = Mockery::mock(HttpResponseCodeWrapper::class);
    $httpResponseCodeCallerMock->shouldReceive('setCode')->once()->with(404);

    $dataPrinterMock = Mockery::mock(DataPrinterWrapper::class);
    $dataPrinterMock->shouldReceive('print')->once()->withAnyArgs();

    $exceptionHandler = new ExceptionHandler($httpResponseCodeCallerMock, $dataPrinterMock);

    // ob_start();
    // $exceptionHandler->handleException(new PageNotFoundException("A Page Is Not Found"));
    // $output = ob_get_clean();

    // expect($output)->toContain('A Page Is Not Found');

    expect($exceptionHandler->handleException(new PageNotFoundException("A Page Is Not Found")))
        ->toBe('Full exception message is shown to the client');
});

it('print the correct message in development mode when other exception is thrown', function(){ 
    $_ENV['APP_ENV'] = 'devlopmentt';

    $httpResponseCodeCallerMock = Mockery::mock(HttpResponseCodeWrapper::class);
    $httpResponseCodeCallerMock->shouldReceive('setCode')->once()->with(500);

    $dataPrinterMock = Mockery::mock(DataPrinterWrapper::class);
    $dataPrinterMock->shouldReceive('print')->once()->withAnyArgs();

    $exceptionHandler = new ExceptionHandler($httpResponseCodeCallerMock, $dataPrinterMock);
 
    // ob_start();
    // $exceptionHandler->handleException(new Exception("Something Went Wrong")); 
    // $output = ob_get_clean();

    expect($exceptionHandler->handleException(new Exception("Something Went Wrong")))->toBe('Full exception message is shown to the client');
});



it('print a generic message in production mode when a page not found exception is thrown', function(){
    $_ENV['APP_ENV'] = 'production'; 
    $httpResponseCodeCallerMock = Mockery::mock(HttpResponseCodeWrapper::class);
    $httpResponseCodeCallerMock->shouldReceive('setCode')->once()->with(404);

    $dataPrinterMock = Mockery::mock(DataPrinterWrapper::class);
    $dataPrinterMock->shouldReceive('print')->never()->withAnyArgs();

    $exceptionHandler = new ExceptionHandler($httpResponseCodeCallerMock, $dataPrinterMock);

    ob_start();
    $exceptionHandler->handleException(new PageNotFoundException("A Page Is Not Found"));
    $output = ob_get_clean(); 

    expect($output)->toContain('404');
});

it('print a generic message in production mode when other exception is thrown', function(){
    $_ENV['APP_ENV'] = 'production'; 

    $httpResponseCodeCallerMock = Mockery::mock(HttpResponseCodeWrapper::class);
    $httpResponseCodeCallerMock->shouldReceive('setCode')->once()->with(500);

    $dataPrinterMock = Mockery::mock(DataPrinterWrapper::class);
    $dataPrinterMock->shouldReceive('print')->never()->withAnyArgs();

    $exceptionHandler = new ExceptionHandler($httpResponseCodeCallerMock, $dataPrinterMock);

    ob_start();
    $exceptionHandler->handleException(new Exception("A Page Is Not Found")); 
    $output = ob_get_clean(); 

    expect($output)->toContain('500');
});