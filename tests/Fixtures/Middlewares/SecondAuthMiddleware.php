<?php

namespace SousControle\Tests\Fixtures\Middlewares;

use Closure;
use SousControle\Core\Request;
use SousControle\Core\Response;

class SecondAuthMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->getUrl() === '/test') {// time as getAuthenticatedUser (only for test purpose)
            return new Response('Unauthorized', 401);
        }

        return $next($request);
    }
}