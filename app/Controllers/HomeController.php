<?php

namespace App\Controllers;

use App\Models\Test;
use SousControle\Core\Controller;
use SousControle\Core\Response; 

class HomeController extends Controller
{
    public function __construct(private Test $testModel)
    {

    }

    public function index(): Response
    {
        $data = $this->testModel->all();
        return $this->view("home/index", ['data' => $data]);
    }
}