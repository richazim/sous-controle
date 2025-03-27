<?php

function env(string $key): string 
{
    if($_ENV[$key]){
        return $_ENV[$key];
    }else{
        throw new Exception("The .env file doesn't contain a value for the key $key. Please create an environment variable for this key");
    }
}