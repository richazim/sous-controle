<?php

namespace App\Controllers;

use SousControle\Core\Controller;
use SousControle\Core\Response; 

class HomeController extends Controller
{
    public function index(): Response
    {
        return $this->view("home/index");
    }
}