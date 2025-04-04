<?php

// ORM: To use objects to manipulate database tables
namespace SousControle\Core;

use PDO;
use SousControle\Core\DatabaseConnection;

abstract class ORMModel
{
    protected PDO $pdo;

    protected string $table; // Example: protected string $table = 'example'; // Custom Table Name Inside The Implemented Model

    public function __construct(DatabaseConnection $databaseConnection)
    {
        $this->pdo = $databaseConnection->getPdo();
    }

    public function getTableName(): string
    {
        if(property_exists($this, 'table') && isset($this->table)){
            return $this->table;
        }
        return strtolower(basename(str_replace('\\', '/', get_class($this))));;
    }

    public function all(): array
    {
        $sql = "SELECT * FROM " . $this->getTableName();
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find(int $id): ?array
    {
        $sql = "SELECT * FROM " . $this->getTableName() . " WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function create(array $data): bool
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        $sql = "INSERT INTO " . $this->getTableName() . " ($columns) VALUES ($placeholders)"; 

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($data);
    }

    public function update(int $id, array $data): bool
    {
        $fields = implode(', ', array_map(fn($key) => "$key = :$key", array_keys($data)));
        $sql = "UPDATE " . $this->getTableName() . " SET $fields WHERE id = :id";
        
        $stmt = $this->pdo->prepare($sql);
        $data['id'] = $id;
        return $stmt->execute($data);
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM " . $this->getTableName() . " WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}