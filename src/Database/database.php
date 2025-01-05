<?php

namespace App\Database;

use PDO;

class Database
{
    private $pdo;

    public function __construct(string $host, string $dbname, string $user, string $password)
    {
        $this->pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getPdo(): PDO
    {
        return $this->pdo;
    }

    public function query(string $query, array $params = []): array
    {
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert(string $table, array $data): bool
    {
        $columns = implode(', ', array_keys($data));
        $values = implode(', ', array_fill(0, count($data), '?'));
        
        $query = "INSERT INTO {$table} ({$columns}) VALUES ({$values})";
        
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute(array_values($data));
    }
}