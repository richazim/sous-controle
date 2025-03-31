<?php

namespace SousControle\Tests\Fixtures\Middlewares;

use Closure;
use SousControle\Core\Middlewares\Middleware;
use SousControle\Core\Request;
use SousControle\Core\Response;

class MiddlewareOne implements Middleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $request->setUrl($request->getUrl() . "- MiddlewareTwo");
        $response = $next($request); 
        $response->setHtml($response->getHtml() . " - MiddlewareOne");
        return $response;
    }
}