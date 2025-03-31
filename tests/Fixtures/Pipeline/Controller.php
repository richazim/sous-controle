<?php

namespace SousControle\Tests\Fixtures\Pipeline;

use SousControle\Core\Response;

class Controller
{
    public function index(): Response
     {
        return new Response('OK', 200);
    }
}