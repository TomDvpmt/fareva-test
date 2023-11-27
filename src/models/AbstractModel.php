<?php

namespace App\models;

use App\Database;
use Exception;
use PDO;

class AbstractModel
{
    protected string $table;
    protected string $where;

    private function setWhere(array $selectors): void
    {
        $params = array_map(fn ($key) => $key . '=:' . $key, array_keys($selectors));
        $this->where = empty($selectors) ? '' : ' WHERE ' . implode(' AND ', $params);
    }

    public function save(array $data): void
    {
        $pdo = Database::connect(true);
        $keys = implode(',', array_map(fn ($key) => '`' . $key . '`', array_keys($data)));
        $placeholders = implode(',', array_map(fn ($key) => ':' . $key, array_keys($data)));
        $query = "
            INSERT INTO $this->table ($keys)
            VALUES ($placeholders);
        ";
        try {
            $statement = $pdo->prepare($query);
            $statement->execute($data);
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage()); // TODO : better error display for user
        }
    }

    public function get(array $selectors = []): array
    {
        $this->setWhere($selectors);
        $query = "SELECT * FROM $this->table $this->where;";
        try {
            $pdo = Database::connect(true);
            $statement = $pdo->prepare($query);
            $check = $statement->execute($selectors);
            if (!$check) throw new Exception('Unable to get data.');
            $results = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage()); // TODO : better error display for user
        }
    }
}
