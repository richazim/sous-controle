<?php 

use SousControle\Core\DotenvLoader; 

require __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/../core/helpers/arrays.php";

// ENV LOADER
$dotenv = new DotenvLoader();
$dotenv->load(); 

// ERROR HANDLING
set_error_handler("SousControle\Core\ExceptionHandler::transformErrorToException");
set_exception_handler("SousControle\Core\ExceptionHandler::handleException");

echo(1/0);


