<?php

namespace App\Middlewares;

use Closure;
use SousControle\Core\Middlewares\Middleware;
use SousControle\Core\Request;
use SousControle\Core\Response;

class CheckAdmin implements Middleware
{
    public function handle(Request $request, Closure $next): Response
    {
        echo "Je suis CheckAdmin et je peux modifier la requete entrée et la reponse que je vais recuperer et retourner<br>";
        return $next($request);
    }
}