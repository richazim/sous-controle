<?php

namespace SousControle\Core\Middlewares;

use Closure;
use SousControle\Core\Request;
use SousControle\Core\Response;

interface Middleware
{
    public function handle(Request $request, Closure $next): Response;
}