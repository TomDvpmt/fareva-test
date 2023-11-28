<?php

namespace App;

use App\models\Perfume;
use Exception;
use PDO;

define('MOCK_COMPONENTS', [
    'alcohol',
    'water',
    'limonene',
    'citral',
    'CI 14700 (red)',
    'CI 19140 (yellow)',
    'polysorbate 20',
    'sodium benzoate',
]);

define('MOCK_PERFUMES', [
    [
        'id' => 1,
        'name' => 'Perfume 1',
        'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque metus turpis, tempus a molestie non, molestie at enim. In dignissim lectus nec sapien pellentesque, nec condimentum purus lacinia. Aliquam erat volutpat. Quisque non blandit nibh, nec bibendum ipsum. Aenean dignissim tincidunt lorem, suscipit luctus urna ullamcorper non.',
        'gender' => 1,
        'components' => [
            'alcohol',
            'water',
            'CI 14700 (red)',
        ]
    ],
    [
        'id' => 2,
        'name' => 'Perfume 2',
        'description' => 'Nulla cursus arcu dolor, a tincidunt est dapibus nec. Interdum et malesuada fames ac ante ipsum primis in faucibus. Curabitur ut placerat arcu, in ultricies orci. Maecenas vel nisl quis sem imperdiet pellentesque ut in quam. Sed sagittis elementum luctus. Suspendisse sodales felis magna.',
        'gender' => 2,
        'components' => [
            'alcohol',
            'water',
            'polysorbate 20',
            'sodium benzoate',
        ]
    ],
    [
        'id' => 3,
        'name' => 'Perfume 3',
        'description' => 'Mauris nulla dui, rutrum quis pretium eu, tincidunt quis arcu. Pellentesque velit ipsum, lacinia quis sapien vel, vulputate tristique nunc. Nulla pellentesque, justo vel pellentesque efficitur, urna massa maximus nisi, in elementum odio quam et libero. Cras accumsan a ex sit amet ornare.',
        'gender' => 2,
        'components' => [
            'alcohol',
            'limonene',
            'citral',
            'sodium benzoate',
        ]
    ]

]);

class Database
{
    public function initialize(): void
    {
        $pdo = $this->connect(false);
        try {
            $this->createDb($pdo);
            $this->createTables();
            $this->populateWithMockData();
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
                description VARCHAR(500) NOT NULL,
                gender INT NOT NULL
            );
            ",
            "
            CREATE TABLE IF NOT EXISTS components (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(100) NOT NULL
            );
            ",
            "
            CREATE TABLE IF NOT EXISTS perfumes_components (
                perfume_id INT NOT NULL,
                component_id INT NOT NULL,
                FOREIGN KEY (perfume_id) REFERENCES perfumes(id),
                FOREIGN KEY (component_id) REFERENCES components(id)
            );
            ",
            "
            CREATE TRIGGER IF NOT EXISTS delete_relation_before_delete_perfume
                BEFORE DELETE 
                ON perfumes FOR EACH ROW
                DELETE FROM perfumes_components
                WHERE perfume_id = old.id;
            "
        ];


        foreach ($queries as $query) {
            $check = $pdo->query($query);
            if (!$check) throw new Exception('Unable to create tables.');
        };
    }

    private function populateWithMockData()
    {
        $pdo = $this->connect(true);

        // Populate components
        foreach (MOCK_COMPONENTS as $component) {

            // check if entry already exsists
            $checkQuery = "
            SELECT * FROM components WHERE name='$component';
            ";
            $statement = $pdo->query($checkQuery);
            $result = $statement->fetch();
            if ($result) {
                continue;
            }

            // write in db
            $query = "INSERT INTO components (`name`) VALUES ('" . $component . "');";
            $check = $pdo->query($query);
            if (!$check) throw new Exception('Unable to populate components table.');
        }

        // Populate perfumes
        foreach (MOCK_PERFUMES as $perfume) {

            // check if entry already exsists
            $checkQuery = "
            SELECT * FROM perfumes WHERE name='" . $perfume['name'] . "';
            ";
            $statement = $pdo->query($checkQuery);
            $result = $statement->fetch();
            if ($result) {
                continue;
            }

            // write in db
            $values = implode("', '", [$perfume['name'], $perfume['description'], $perfume['gender']]);
            $query = "INSERT INTO perfumes (`name`, `description`, `gender`) VALUES ('$values');";
            $check = $pdo->query($query);
            if (!$check) throw new Exception('Unable to populate perfumes table.');
        }

        // Populate perfumes_components
        foreach (MOCK_PERFUMES as $perfume) {
            $perfumeId = $perfume['id'];
            foreach ($perfume['components'] as $component) {

                // get component id
                $query = "SELECT id FROM components WHERE name = '$component';";
                $componentId = $pdo->query($query)->fetch(PDO::FETCH_ASSOC)['id'];

                // check if relation already exsists
                $checkQuery = "
                SELECT * FROM perfumes_components WHERE component_id = $componentId AND perfume_id = $perfumeId;
                ";
                $statement = $pdo->query($checkQuery);
                $result = $statement->fetch();
                if ($result) {
                    continue;
                }

                // write in db
                $values = implode("', '", [$perfumeId, $componentId]);
                $query = "INSERT INTO perfumes_components (`perfume_id`, `component_id`) VALUES ('$values');";
                $check = $pdo->query($query);
                if (!$check) throw new Exception('Unable to populate perfumes_components table.');
            }
        }
    }
}
