<?php

namespace SousControle\Tests\Fixtures\Models;

use SousControle\Core\ORMModel;

class ModelWithTableName extends ORMModel
{
    protected string $table = "example";
}