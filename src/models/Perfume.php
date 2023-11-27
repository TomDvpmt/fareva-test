<?php

namespace App\models;

class Perfume extends AbstractModel
{
    private string $name;
    private string $description;

    public function __construct()
    {
        $this->table = 'perfumes';
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }
}
