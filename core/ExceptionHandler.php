<?php

namespace SousControle\Core;

use ErrorException;
use SousControle\Core\Exceptions\PageNotFoundException;
use Throwable;

class ExceptionHandler
{ 
    public function __construct(private HttpResponseCodeWrapper $httpResponseCodeWrapper)
    {

    }

    public function handleException(Throwable $exception): void
    { 

        if($exception instanceof PageNotFoundException){
            $this->httpResponseCodeWrapper->setCode(404);
            $production_exception_template = '404.php';
        }else{
            $this->httpResponseCodeWrapper->setCode(500);
            $production_exception_template = '500.php';
        }

        if(strtolower(config('app.env') !== 'production')){ 
            echo var_export(convertToArray($exception), true);
        }else{
            require __DIR__ . "/../views/errors/$production_exception_template";
            logException($exception);
        }
    }
}