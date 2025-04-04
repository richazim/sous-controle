<?php

namespace SousControle\Tests\Fixtures\RequestToControllerHandler;

use SousControle\Core\Controller;

class FakeControllerWithArgumentToCall extends Controller
{  
    public function index(string $id){
        return $id;
    }
}   