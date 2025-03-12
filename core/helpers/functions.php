<?php

function env(string $key): string 
{
    if($_ENV[$key]){
        return $_ENV[$key];
    }else{
        throw new Exception("The .env file doesn't contain a value for the key $key. Please create an environment variable for this key");
    }
}

function config(string $key): string
{
    $parts = splitAtFirstDot($key); 
    $file = $parts[0]; 

    $configArray = require __DIR__ . "/../../config/$file.php";
    $configArrayKey = $parts[1];
    return $configArray[$configArrayKey];
}