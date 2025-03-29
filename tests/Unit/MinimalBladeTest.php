<?php

use SousControle\Core\Exceptions\FileUnfoundException;
use SousControle\Core\Templating\MinimalBlade; 

beforeEach(function () { 
    $this->engine = new MinimalBlade(); 
    $this->engine->VIEWS_DIR = __DIR__ . '/../resources/views/';
});

it('renders correctly a simple template', function(){
    $content = $this->engine->process("simple_template");
    
    expect($content)->toContain("Simple Template");
});

it('renders correctly a template with variable', function(){
    $content = $this->engine->process("template_with_variable", ["name" => "Sous Controle"]);
    
    expect($content)->toContain("Sous Controle"); 
});

it('renders safely a template with variable', function(){
    $content = $this->engine->process("template_with_variable", ["name" => "<script>console.log('XSS')</script>"]); 
    expect($content)->not()->toContain("<script>console.log('XSS')</script>");
});

it('renders correctly a template with php code', function(){
    $content = $this->engine->process("template_with_php_code");
    
    expect($content)->toContain("7");
});

it('replaces @include with file content', function(){
    $content = $this->engine->process("template_including_other_template");
    
    expect($content)->toContain("Included content");
});

it('renders an extended template', function(){
    $container = $this->engine->process("child");

    expect($container)->toContain("Hello, World!");
});

it('throws an exception if the template is not found', function(){
    expect(fn() => $this->engine->process("unknown_template"))
        ->toThrow(FileUnfoundException::class);
});