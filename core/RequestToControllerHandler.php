<?php

namespace SousControle\Core;

use ReflectionMethod;
use SousControle\Core\Container;
use SousControle\Core\Request;
use SousControle\Core\Response;
use SousControle\Core\Templating\MinimalBlade; 

class RequestToControllerHandler
{
    public function handle(Request $request, array $params, Container $container): Response
    {
        $controller = $container->getInstance($params['controller']);

        $controller->setRequest($request);
        $controller->setTemplateViewer($container->getInstance(MinimalBlade::class));
        $controller->setResponse(new Response());

        return $controller->{$params['action']}(...$this->getControllerActionArgs($controller, $params['action'], $params));
    }

    private function getControllerActionArgs($controllerObject, $actionName, array $params): array
    {
        $args = [];

        $method = new ReflectionMethod($controllerObject, $actionName);

        foreach($method->getParameters() as $parameter){
            $name = $parameter->getName();

            if(isset($params[$name])){
                $args[$name] = $params[$name];
            }
        }

        return $args;
    }
}