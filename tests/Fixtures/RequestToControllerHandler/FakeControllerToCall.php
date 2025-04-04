<?php

namespace SousControle\Tests\Fixtures\RequestToControllerHandler;

use SousControle\Core\Controller;
use SousControle\Core\Response;

class FakeControllerToCall extends Controller
{
    public function index(): Response
    {
        return new Response("Hello World!");
    }
}