<?php

namespace SousControle\Core;

use Exception;
use SousControle\Core\Exceptions\RouteNotFoundException;
use SousControle\Core\Request;

class Router
{
    private array $routes = [];

    public function __construct()
    {

    }

    public function add(array|string $urlMethodPair, array $paramsArray = [], array $middlewares = []): void
    {
        if(is_string($urlMethodPair)) {
            $urlMethodPair = [
                'url' => $urlMethodPair,
                'method' => 'GET'
            ];
        }

        if(is_array($urlMethodPair) && empty($urlMethodPair['method'])) {
            $urlMethodPair['method'] = 'GET';
        }

        $this->routes[] = [
            "urlMethodPair" => $urlMethodPair,
            "paramsArray" => $paramsArray,
            "middlewares" => ["middlewares" => $middlewares]
        ];
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }

    public function match(Request $request): array // match a request to a route and return the matched route's params (contained the captured values, the paramsArray and the middlewares)
    { 
        foreach ($this->routes as $route) { // For each stored route 
            $urlPattern = $this->transformRouteUrlToPattern($route["urlMethodPair"]["url"]); 
            if (preg_match($urlPattern, trim($request->getUrl(), "/"), $matches)) { 
                $matches = array_filter($matches, "is_string", ARRAY_FILTER_USE_KEY); // Keep only array case with string key (to ensure it is the captured one when processing matches) 
                $params = array_merge($matches, $route["paramsArray"], $route["middlewares"], ['method' => $route["urlMethodPair"]['method']]);  
                if (strtolower($params['method']) !== strtolower($request->getMethod())) { 
                    continue; 
                } 
                return $params;
            }
        }

        throw new RouteNotFoundException("Route not found for the request url: " . $request->getUrl());
    }

    private function transformRouteUrlToPattern(string $route_url): string
    { 
        $route_url = trim($route_url, "/");

        $segments = explode("/", $route_url); // all the route_url parts whithout /

        $segments = array_map(function(string $segment): string { 

            if (preg_match("#^\{([a-z][a-z0-9]*)\}$#", $segment, $matches)) { // if a segment is variable

                return "(?<" . $matches[1] . ">[^/]+)"; // [^/]* to authorize even many characters, e.g. _, ., etc...

            }

            if (preg_match("#^\{([a-z][a-z0-9]*):(.+)\}$#", $segment, $matches)) { // if a segment is constrained constant

                return "(?<" . $matches[1] . ">" . $matches[2] . ")";

            } 

            return $segment; 
        }, $segments);

        return "#^" . implode("/", $segments) . "$#iu";
    }
}