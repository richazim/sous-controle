<?php

namespace SousControle\Core\Middlewares;

use SousControle\Core\Request;
use SousControle\Core\Response;

interface Middleware
{
    public function handle(Request $request): Response;
}