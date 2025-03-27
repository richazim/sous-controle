<?php

function config(string $key): string
{
    $parts = splitAtFirstDot($key); 
    $file = $parts[0]; 

    $configArray = require __DIR__ . "/../../config/$file.php";
    $configArrayKey = $parts[1];
    return $configArray[$configArrayKey];
}