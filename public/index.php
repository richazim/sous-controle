<?php 

use SousControle\Core\DotenvLoader;
use SousControle\Core\ExceptionHandler;
use SousControle\Core\HttpResponseCodeWrapper;
use SousControle\Core\Kernel as CoreKernel; 
use SousControle\Core\Request; 

require __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/../core/helpers/arrays.php";

// ENV LOADER
$dotenv = new DotenvLoader();
$dotenv->load(base_path('.env')); 

// ERROR HANDLING
$httpResponseCodeWrapper = new HttpResponseCodeWrapper();
$exceptionHandler = new ExceptionHandler($httpResponseCodeWrapper);
set_error_handler(callback: "SousControle\Core\ErrorHandler::transformErrorToException");
set_exception_handler(callback: [$exceptionHandler, 'handleException']); 

// REQUEST INITIALIZATION
$request = new Request(
    $_SERVER['REQUEST_URI'],
    $_SERVER['REQUEST_METHOD'],
    $_FILES,
    $_POST,
    $_GET
); 


// ROUTES INITIALIZATION
$router = require __DIR__ . "/../config/routes.php"; 


// CONTAINER INITIALIZATION
$container = require __DIR__ . "/../config/services.php"; 

// CORE KERNEL
$kernel = new CoreKernel($request, $router, $container);

// RESPONSE
$response = $kernel->getResponse(); 
$response->respond();