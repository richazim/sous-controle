<?php

use SousControle\Core\DatabaseConnection;
use SousControle\Tests\Fixtures\Models\ModelWithoutTableName;
use SousControle\Tests\Fixtures\Models\ModelWithTableName;

it('can get a the correct table name if the table name is specified', function(){
    $pdoMock = Mockery::mock(PDO::class);
    $databaseMock = Mockery::mock(DatabaseConnection::class);
    $databaseMock->shouldReceive('getPDO')->andReturn($pdoMock);

    $modelWithTableName = new ModelWithTableName($databaseMock);
    expect($modelWithTableName->getTableName())->toBe("example");
});

it('can get a the correct table name if the table name is not specified', function(){
    $pdoMock = Mockery::mock(PDO::class);
    $databaseMock = Mockery::mock(DatabaseConnection::class);
    $databaseMock->shouldReceive('getPDO')->andReturn($pdoMock);

    $modelWithoutTableName = new ModelWithoutTableName($databaseMock);
    expect($modelWithoutTableName->getTableName())->toBe("modelwithouttablename");
});

// For crud operations, the will be tested as integration tests