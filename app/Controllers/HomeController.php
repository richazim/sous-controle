<?php

namespace App\Controllers;

use SousControle\Core\Response;

class HomeController
{
    public function index()
    {
        return new Response("Je suis de l'action index du Controleur Home");
    }
}