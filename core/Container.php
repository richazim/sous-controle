<?php

namespace SousControle\Core;

use Closure;
use Exception;
use ReflectionClass;
use ReflectionUnionType;
use SousControle\Core\Exceptions\ContainerException;

class Container
{
    private array $container = [];

    public function addService(string $className, Closure $closure): void
    {
        $this->container[$className] = $closure;
    }

    public function getInstance(string $className): mixed
    { 
        if(array_key_exists($className, $this->container)){
            return $this->container[$className]();
        } 

        if(!$this->isConstructorExist($className)){
            return new $className();
        }

        if(!$this->isConstructorContainArguments($className)){
            return new $className();
        }

        if($this->constructorContainArgumentWithManyTypesOrArgumentWithoutType($className)){
            throw new ContainerException("The constructor argument of the class $className must have a single type declaration, to be able to use Dependency Injection");
        }

        if($this->isConstructorContainBuiltInType($className)){
            throw new ContainerException("The constructor argument of the class $className must not be a built-in type, to be able to use Dependency Injection");
        } 

        $dependencies = [];

        $reflection = new ReflectionClass($className);
        $constructor = $reflection->getConstructor();
        
        foreach($constructor->getParameters() as $param){
            $dependencies[] = $this->getInstance($param->getType()->getName());
        }

        return new $className(...$dependencies);
    }

    private function isConstructorExist(string $className): bool
    {
        $reflection = new ReflectionClass($className);
        $constructor = $reflection->getConstructor();
        if ($constructor) {
            return true;
        }
        return false;
    }

    private function isConstructorContainArguments(string $className): bool
    { 
        $reflection = new ReflectionClass($className);
        $constructor = $reflection->getConstructor();
        if ($constructor->getNumberOfParameters() > 0) {
            return true;
        }
        return false;
    }

    private function constructorContainArgumentWithManyTypesOrArgumentWithoutType(string $className): bool
    {
        $reflection = new ReflectionClass($className);
        $constructor = $reflection->getConstructor();

        foreach ($constructor->getParameters() as $param) {
            $type = $param->getType();

            if (!$type || $type instanceof ReflectionUnionType) {
                return true;
            }
        }
        return false;
    }

    private function isConstructorContainBuiltInType(string $className): bool
    {
        $reflection = new ReflectionClass($className);
        $constructor = $reflection->getConstructor();

        foreach ($constructor->getParameters() as $param) {
            $type = $param->getType();

            if ($type->isBuiltin()) {
                return true;
            }
        }
        return false;
    }
}