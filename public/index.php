<?php 

use SousControle\Core\DotenvLoader;
use SousControle\Core\Request;
use SousControle\Core\Response;
use SousControle\Core\Route;

require __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/../core/helpers/arrays.php";

// ENV LOADER
$dotenv = new DotenvLoader();
$dotenv->load(); 

// ERROR HANDLING
set_error_handler("SousControle\Core\ExceptionHandler::transformErrorToException");
set_exception_handler("SousControle\Core\ExceptionHandler::handleException"); 

// echo(1/0);

// REQUEST INITIALIZATION
$request = new Request(
    $_SERVER['REQUEST_URI'],
    $_SERVER['REQUEST_METHOD'],
    $_FILES,
    $_POST,
    $_GET
);

// RESPONSE INITIALIZATION
$response = new Response();


// ROUTES INITIALIZATION
$routes = require __DIR__ . "/../config/routes.php";

$params = $routes->match($request);

dump($params);