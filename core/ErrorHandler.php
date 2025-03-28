<?php

namespace SousControle\Core;

use ErrorException;

class ErrorHandler
{
    public static function transformErrorToException(int $errno, string $errmsg, string $errfile, int $errline): void
    {
        throw new ErrorException($errmsg, $errno, E_ERROR, $errfile, $errline);
    } 
}