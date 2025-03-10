<?php 

use SousControle\Core\DotenvLoader;

require __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/../core/helpers/arrays.php";

$dotenv = new DotenvLoader();
$dotenv->load(); 

dump($_ENV);