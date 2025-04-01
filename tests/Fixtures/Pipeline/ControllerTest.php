<?php

namespace SousControle\Tests\Fixtures\Pipeline;

use SousControle\Core\Controller;
use SousControle\Core\Response;

class ControllerTest extends Controller
{
    public function index(): Response
     {
        return new Response('OK', 200);
    }
}