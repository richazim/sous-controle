<?php

namespace App\Middlewares;

use SousControle\Core\Middlewares\Middleware;
use SousControle\Core\Request;
use SousControle\Core\Response;

class CheckAdmin implements Middleware
{
    public function handle(Request $request): Response
    {
        exit;
    }
}