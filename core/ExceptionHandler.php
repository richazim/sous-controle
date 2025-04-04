<?php

namespace SousControle\Core;

use SousControle\Core\DataPrinterWrapper;
use ErrorException;
use SousControle\Core\Exceptions\PageNotFoundException;
use Throwable;

class ExceptionHandler
{ 
    public function __construct(private HttpResponseCodeWrapper $httpResponseCodeWrapper, private DataPrinterWrapper $dataPrinter)
    {

    }

    public function handleException(Throwable $exception): string
    { 

        if($exception instanceof PageNotFoundException){
            $this->httpResponseCodeWrapper->setCode(404);
            $production_exception_template = '404.php';
        }else{
            $this->httpResponseCodeWrapper->setCode(500);
            $production_exception_template = '500.php';
        }

        if(strtolower(config('app.env') !== 'production')){ 
            $this->dataPrinter->print(convertToArray($exception));
            return 'Full exception message is shown to the client';
        }else{
            require __DIR__ . "/../views/errors/$production_exception_template";
            logException($exception);
        }
        return '';
    }
}