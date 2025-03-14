<?php

namespace SousControle\Core\Templating;

interface TemplatingEngine
{
    public function process(string $template, array $data = []): string;
}