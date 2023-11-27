<?php

namespace App\models;

use App\Database;
use Exception;
use PDO;

class Perfume extends AbstractModel
{
    private int $id;

    public function __construct()
    {
        $this->setTable('perfumes');
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function addComponentsToPerfume(array $checkedComponents)
    {
        foreach ($checkedComponents as $componentName) {
            $component = new Component;
            $alreadyExists = $component->get(['name' => $componentName]);
            if (!$alreadyExists) {
                $component->save(['name' => $componentName]);
            }
            $componentId = $component->get(['name' => $componentName])[0]['id'];
            $component->addPerfumeComponentRelation(['perfume_id' => $this->id, 'component_id' => $componentId]);
        }
    }

    public function getComponents(int $perfumeId): array
    {
        $pdo = Database::connect(true);

        $query = "
            SELECT c.name
            FROM perfumes p
            JOIN perfumes_components pc
            ON p.id = :id AND pc.perfume_id = p.id
            JOIN components c
            ON c.id = pc.component_id
        ";

        $statement = $pdo->prepare($query);
        $check = $statement->execute(['id' => $perfumeId]);
        if (!$check) throw new Exception('Unable to get components.');
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }
}
