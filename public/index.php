<?php 

use SousControle\Core\DotenvLoader;
use SousControle\Core\Middlewares\Pipeline;
use SousControle\Core\Request;
use SousControle\Core\Response; 
use SousControle\Core\Templating\TemplatingEngine;

require __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/../core/helpers/arrays.php";

// ENV LOADER
$dotenv = new DotenvLoader();
$dotenv->load(base_path('.env')); 

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
$params = $route->match($request);

// $params = $routes->match($request); 

// SOUS-CONTROLE CONTAINER INITIALIZATION
$container = require __DIR__ . "/../config/services.php"; 

// TEMPLATING ENGINE TESTING
// $templatingEngine = $container->getInstance(TemplatingEngine::class); 
// dump($templatingEngine->process('home/index', ['name' => 'Azim']));

// IMPLEMENTING MIDDLEWARE PIPELINES
$pipeline = new Pipeline($request,  $params, $container);
dump($pipeline->getResponse());