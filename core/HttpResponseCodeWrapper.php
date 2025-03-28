<?php

namespace SousControle\Core;

class HttpResponseCodeWrapper
{
    public function setCode(int $code): void
    {
        http_response_code($code);
    }
}