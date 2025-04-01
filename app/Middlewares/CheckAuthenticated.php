<?php

namespace App\Middlewares;

use Closure;
use SousControle\Core\Middlewares\Middleware;
use SousControle\Core\Request;
use SousControle\Core\Response;

class CheckAuthenticated implements Middleware
{
    public function handle(Request $request, Closure $next): Response
    { 
        $response = $next($request); 
        return $response;
    }
}