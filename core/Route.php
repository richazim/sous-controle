<?php

namespace SousControle\Core;

use Exception;
use SousControle\Core\Exceptions\RouteNotFoundException;
use SousControle\Core\Request;

class Route
{
    private array $routes = [];

    public function __construct()
    {

    }

    public function add(array|string $urlArray, array $paramsArray = [], array $middlewares = []): void
    {
        if(is_string($urlArray)) {
            $urlArray = [
                'url' => $urlArray,
                'method' => 'GET'
            ];
        }

        if(is_array($urlArray) && empty($urlArray['method'])) {
            $urlArray['method'] = 'GET';
        }

        $this->routes[] = [
            "urlArray" => $urlArray,
            "paramsArray" => $paramsArray,
            "middlewares" => $middlewares
        ];
    }

    public function match(Request $request): array // match a request to a route and return the matched route's params (contained the captured values, the paramsArray and the middlewares)
    { 
        foreach ($this->routes as $route) { // For each stored route 
            $urlPattern = $this->transformRouteUrlToPattern($route["urlArray"]["url"]); 
            if (preg_match($urlPattern, trim($request->__get('url'), "/"), $matches)) { 
                $matches = array_filter($matches, "is_string", ARRAY_FILTER_USE_KEY); // Keep only array case with string key (to ensure it is the captured one when processing matches) 
                $params = array_merge($matches, $route["paramsArray"], $route["middlewares"], ['method' => $route["urlArray"]['method']]);  
                if (strtolower($params['method']) !== strtolower($request->__get('method'))) { 
                    continue; 
                } 
                return $params;
            }
        }

        throw new RouteNotFoundException("Route not found for the request url: " . $request->__get('url'));
    }

    private function transformRouteUrlToPattern(string $route_url): string
    { 
        $route_url = trim($route_url, "/");

        $segments = explode("/", $route_url); // all the route_url parts whithout /

        $segments = array_map(function(string $segment): string {
            if(strpos($segment, '{') === false){
                return $segment;
            }

            if (preg_match("#^\{([a-z][a-z0-9]*)\}$#", $segment, $matches)) { // if a segment is variable

                return "(?<" . $matches[1] . ">[^/]*)";

            }

            if (preg_match("#^\{([a-z][a-z0-9]*):(.+)\}$#", $segment, $matches)) { // if a segment is constrained constant

                return "(?<" . $matches[1] . ">" . $matches[2] . ")";

            } 

            dump("le dernier return est atteint dans l'objet de routes");

            return $segment; // I guess this return will not be reached but it's here just in case and also to avoid return error

        }, $segments);

        return "#^" . implode("/", $segments) . "$#iu";
    }
}