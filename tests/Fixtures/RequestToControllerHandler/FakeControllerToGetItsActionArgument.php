<?php

namespace SousControle\Tests\Fixtures\RequestToControllerHandler;

use SousControle\Core\Controller;

class FakeControllerToGetItsActionArgument extends Controller
{  
    public function index(string $id){
        return $id;
    }
}   