<?php

use SousControle\Core\Container;
use SousControle\Core\Exceptions\ContainerException;
use SousControle\Tests\Fixtures\Services\InvalidServiceContainingArgumentWithoutType;
use SousControle\Tests\Fixtures\Services\InvalidServiceContainingBuiltInType;
use SousControle\Tests\Fixtures\Services\InvalidServiceContainingDoubleTypes;
use SousControle\Tests\Fixtures\Services\ServiceA;
use SousControle\Tests\Fixtures\Services\ServiceB;
use SousControle\Tests\Fixtures\Services\ServiceC;

beforeEach(function(){
    $this->container = new Container();
});

it('can add and retrieve a service', function(){
    $this->container->addService(ServiceA::class, function(){
        return new ServiceA();
    });

    $instance = $this->container->getInstance(ServiceA::class);

    expect($instance)->toBeInstanceOf(ServiceA::class);
});


it('can instantiate a class withouth dependencies', function(){
    $instance = $this->container->getInstance(ServiceB::class);

    expect($instance)->toBeInstanceOf(ServiceB::class);
});


it('can instantiate a class with objects as dependencies', function(){
    $instance = $this->container->getInstance(ServiceC::class);

    expect($instance)->toBeInstanceOf(ServiceC::class);
});


it('throws ContainerException if trying to instantiate a class with invalid dependencies (argument with double type)', function(){
    expect(function() {
        $this->container->getInstance(InvalidServiceContainingDoubleTypes::class);
    })->toThrow(ContainerException::class);
});

it('throws ContainerException if trying to instantiate a class with invalid dependencies (argument without type)', function(){
    expect(function() {
        $this->container->getInstance(InvalidServiceContainingArgumentWithoutType::class);
    })->toThrow(ContainerException::class);
});

it('throws ContainerException if trying to instantiate a class with invalid dependencies (argument with built in type)', function(){
    expect(function() {
        $this->container->getInstance(InvalidServiceContainingBuiltInType::class);
    })->toThrow(ContainerException::class);
});