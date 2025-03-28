<?php

function convertToArray(Throwable $exception): array
{
    return [ 
        "Exception" => $exception->getMessage(),
        "File" => $exception->getFile(),
        "Line" => $exception->getLine(),
        "Trace" => $exception->getTraceAsString()
    ];
} 

function logException(Throwable $e): void
{
    $date = date('Y-m-d H:i:s');
    $fileName = __DIR__ . "/../../storage/logs/" . date('Y-m-d');
    $logMessage = "[" . $date . "] Exception: " . $e->getMessage() .
                  " \nin " . $e->getFile() . " \non line " . $e->getLine() . "\nTrace: " . $e->getTraceAsString() . "\n\n";
    
    file_put_contents($fileName, $logMessage, FILE_APPEND);
}