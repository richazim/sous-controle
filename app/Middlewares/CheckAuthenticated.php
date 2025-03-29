<?php

namespace App\Middlewares;

use Closure;
use SousControle\Core\Middlewares\Middleware;
use SousControle\Core\Request;
use SousControle\Core\Response;

class CheckAuthenticated implements Middleware
{
    public function handle(Request $request, Closure $next): Response
    {
        echo "Je suis CheckAuthenticated et je peux modifier la requete entrée et la reponse que je vais recuperer et retourner<br>";
        $response = $next($request);
        $response->setHtml($response->getHtml() . "\n Modification de la reponse par le middleware CheckAuthenticated");
        return $response;
    }
}