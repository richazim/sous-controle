<?php

use SousControle\Core\DotenvLoader;

beforeEach(function () {
    file_put_contents(__DIR__ . "/../../.env.test", 'APP_ENV=testing' . PHP_EOL . 'APP_URL=http://localhost' . PHP_EOL);
});

it('loads the environment file variables inside the $_ENV correctly', function(){
    $dotenv = new DotenvLoader();
    $dotenv->load(base_path('.env.test')); 
    expect($_ENV['APP_ENV'])->toBe('testing');
    expect($_ENV['APP_URL'])->toBe('http://localhost');
});

afterEach(function(){
    unlink(base_path('.env.test'));
});