<?php

namespace App\controllers;

use App\models\Perfume;

class PerfumeController extends AbstractController
{
    public function index(): void
    {
        empty($_POST) ? $this->view('pages/add-perfume') : $this->addPerfume();
    }

    public function addPerfume(): void
    {
        $name = strip_tags($_POST['name']);
        $description = strip_tags($_POST['description']);

        $perfume = new Perfume;
        $alreadyExists = $perfume->get(['name' => $name]);
        if ($alreadyExists) {
            $this->view('pages/add-perfume', ['errorMessage' => 'A perfume with this name already exists.', 'name' => $name, 'description' => $description]);
        }
        $perfume->save(['name' => $name, 'description' => $description]);
        $this->view('pages/add-perfume', ['successMessage' => 'Perfume added.']);
    }
}
