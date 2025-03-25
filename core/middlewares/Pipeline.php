<?php

namespace SousControle\Core\Middlewares;

use Closure;
use SousControle\Core\Container;
use SousControle\Core\Request;
use SousControle\Core\Response;

class Pipeline
{
    private array $executableMiddlewares = [];
    public function __construct(
        private Request $request, 
        private array $params, 
        private Container $container
        )
    {
        $this->executableMiddlewares = $this->params['middlewares'];
    }

    public function getResponse(): Response
    { 
        if(!empty($this->executableMiddlewares)){
            $middleware = array_shift($this->executableMiddlewares);
            $response = $this->container->getInstance($middleware) -> handle($this->request, Closure::fromCallable([$this, 'next']));
        } 

        return $this->container->getInstance($this->params['controller']) -> {$this->params['action']}(); 
    }

    public function next(Request $request): Response
    {
        $this->request = $request;
        return $this->getResponse();
    }
}