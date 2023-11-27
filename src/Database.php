<?php

namespace App;

use Exception;
use PDO;

class Database
{
    public function initialize(): void
    {
        $pdo = $this->connect(false);
        try {
            $this->createDb($pdo);
            $this->createTables();
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage()); // TODO : better error display for user
        }
    }

    public static function connect(bool $withDbName): PDO
    {
        $dbName = $withDbName ? ';dbname=' . $_ENV['DB_NAME'] : '';
        $dsn = 'mysql:host=' . $_ENV['DB_HOST'] . $dbName;
        try {
            $pdo = new PDO($dsn, $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
            if (!$pdo) throw new Exception('Unable to connect to database.');
            return $pdo;
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage()); // TODO : better error display for user
        }
    }

    private function createDb(PDO $pdo): void
    {
        $query = "CREATE DATABASE IF NOT EXISTS fareva_test";
        $pdo->query($query);
    }

    private function createTables(): void
    {
        $pdo = $this->connect(true);

        $queries = [
            "
            CREATE TABLE IF NOT EXISTS perfumes (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(100) NOT NULL,
                description VARCHAR(500) NOT NULL
            );
            ",
            "
            CREATE TABLE IF NOT EXISTS components (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(100) NOT NULL,
                perfume_id INT NOT NULL,
                FOREIGN KEY (perfume_id) REFERENCES perfumes(id)
            );
            "
        ];

        foreach ($queries as $query) {
            $check = $pdo->query($query);
            if (!$check) throw new Exception('Unable to create tables');
        };
    }
}
