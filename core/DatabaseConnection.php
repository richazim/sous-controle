<?php

namespace SousControle\Core;

use PDO;

class DatabaseConnection
{
    private ?PDO $pdo;

    public function __construct(private string $host, private string $dbname, private string $username, private string $password)
    {
        
    }

    public function getPdo(): PDO
    {
        $dsn = "mysql:host={$this->host};dbname={$this->dbname}";
        if(empty($this->pdo)){
            $this->pdo = new PDO($dsn, $this->username, $this->password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
        }

        return $this->pdo;
    }
}