<?php

namespace SousControle\Core;

use SousControle\Core\Request;
use SousControle\Core\Response;
use SousControle\Core\Templating\TemplatingEngine;

abstract class Controller
{
    protected Request $request;
    protected TemplatingEngine $templateViewer;
    protected Response $response;

    public function setRequest(Request $request): void
    {
        $this->request = $request;
    }

    public function setTemplateViewer(TemplatingEngine $templateViewer): void
    {
        $this->templateViewer = $templateViewer;
    }

    public function setResponse(Response $response): void
    {
        $this->response = $response;
    } 


    public function view(string $templateName, array $data = []): Response
    {
        $this->response->setHtml($this->templateViewer->process($templateName, $data));
        return $this->response;
    }
}