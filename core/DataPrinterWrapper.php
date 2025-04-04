<?php

namespace SousControle\Core;

class DataPrinterWrapper
{
    public function print($data): void
    {
        dump($data);
    }
}