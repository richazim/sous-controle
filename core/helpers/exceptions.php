<?php

function printException(Throwable $exception): void
{
    echo("Exception Rised: ");
    dump($exception);
    echo("Stack Trace: ");
    dump($exception->getTraceAsString());
}

function printSimpleTemplate(string $templatePath): void
{
    require $templatePath;
}

function logException(Throwable $e): void
{
    $date = date('Y-m-d H:i:s');
    $fileName = __DIR__ . "/../../storage/logs/" . date('Y-m-d');
    $logMessage = "[" . $date . "] Exception: " . $e->getMessage() .
                  " \nin " . $e->getFile() . " \non line " . $e->getLine() . "\nTrace: " . $e->getTraceAsString() . "\n\n";
    
    file_put_contents($fileName, $logMessage, FILE_APPEND);
}