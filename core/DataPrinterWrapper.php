<?php

namespace Core;

class DataPrinterWrapper
{
    public function print($data): void
    {
        dump($data);
    }
}