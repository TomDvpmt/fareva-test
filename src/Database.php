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
                PRIMARY KEY (perfume_id, component_id),
                FOREIGN KEY (perfume_id) REFERENCES perfumes(id) ON DELETE CASCADE,
                FOREIGN KEY (component_id) REFERENCES components(id)
            );
            ",
            "
            CREATE TRIGGER IF NOT EXISTS delete_relation_before_delete_perfume
            BEFORE DELETE 
            ON perfumes FOR EACH ROW
            DELETE FROM perfumes_components
            WHERE perfume_id = OLD.id;
            "
        ];


        foreach ($queries as $query) {
            $check = $pdo->query($query);
            if (!$check) throw new Exception('Unable to create tables.');
        };
    }

    private function populateWithMockData()
    {
        if (!$_SESSION['populated']) {
            foreach (MOCK_PERFUMES as $perfume) {
                $perfumeData = ['name' => $perfume['name'], 'description' => $perfume['description'], 'gender' => $perfume['gender']];
                $newPerfume = new Perfume;
                if ($newPerfume->get(['name' => $perfume['name']])) continue;
                $newPerfume->save($perfumeData);

                /* Add components */
                $perfumeId = $newPerfume->get(['name' => $perfume['name']])[0]['id'];
                $newPerfume->setId($perfumeId);
                $newPerfume->addComponentsToPerfume($perfume['components']);
            }

            $_SESSION['populated'] = true;
        }
    }
}
