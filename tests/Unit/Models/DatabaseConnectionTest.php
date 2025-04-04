<?php

use SousControle\Core\DatabaseConnection;
use SousControle\Core\DotenvLoader;

it('really get pdo instance', function(){
    $dotenv = new DotenvLoader();
    $dotenv->load(base_path('.env')); 
    
    $databaseConnection = new DatabaseConnection(env('DATABASE_HOST'), env('DATABASE_NAME'), env('DATABASE_USERNAME'), env('DATABASE_PASSWORD'));

    expect($databaseConnection->getPdo())->toBeInstanceOf(PDO::class);
});