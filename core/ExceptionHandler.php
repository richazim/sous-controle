<?php

namespace SousControle\Core;

use ErrorException;
use SousControle\Core\Exceptions\PageNotFoundException;
use Throwable;

class ExceptionHandler
{
    public static function transformErrorToException(int $errno, string $errmsg, string $errfile, int $errline): void
    {
        throw new ErrorException($errmsg, $errno, E_ERROR, $errfile, $errline);
    } 

    public static function handleException(Throwable $exception): void
    { 
        if($exception instanceof PageNotFoundException){
            http_response_code(404); 
            $production_exception_template = '404.php';
        }else{
            http_response_code(500); 
            $production_exception_template = '500.php';
        }

        if(strtolower(config('app.env') !== 'production')){ 
            printException($exception);
        }else{
            printSimpleTemplate(__DIR__ . "/../views/errors/$production_exception_template");
            logException($exception);
        }
    }
}