<?php

namespace App\models;

use App\Database;
use Exception;

class Component extends AbstractModel
{

    public function __construct()
    {
        $this->setTable('components');
    }

    public function addPerfumeComponentRelation(array $ids): void
    {
        $this->setTable('perfumes_components');
        $this->save($ids);
    }
}
