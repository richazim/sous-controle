<?php

namespace SousControle\Core;

use SousControle\Core\Exceptions\InvalidCallException;

class Request
{
  public function __construct(private string $url = '', private string $method = '', private array $files = [], private array $post = [], private array $get = [])
  {

  }

  public function getUrl(): string
  {
    return $this->url;
  }

  public function getMethod(): string
  { 
    return $this->method;
  }

  public function getFiles(): array
  {
    return $this->files;
  }

  public function getPost(): array
  {
    return $this->post;
  }

  public function getGet(): array
  {
    return $this->get;
  }

  public function setUrl(string $url): void
  {
    $this->url = $url;
  }

  public function setMethod(string $method): void
  {
    $this->method = $method;
  }

  public function setFiles(array $files): void
  {
    $this->files = $files;
  }

  public function setPost(array $post): void
  {
    $this->post = $post;
  }

  public function setGet(array $get): void
  {
    $this->get = $get;
  }

  public static function createFromGlobals(): self // to easily create a request from $_SERVER, $_GET, $_POST, $_FILES
  {
    return new self(
      url: $_SERVER['REQUEST_URI'],
      method: $_SERVER['REQUEST_METHOD'],
      files: $_FILES,
      post: $_POST,
      get: $_GET
    );
  }
}