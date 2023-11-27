<?php

namespace App\controllers;

use App\models\Component;
use App\models\Perfume;

class PerfumeController extends AbstractController
{
    public function index(): void
    {
    }

    public function getPerfume(): void
    {
        if (empty($_GET['id'])) {
            header('Location: /');
        }

        $id = strip_tags($_GET['id']);
        $perfume = (new Perfume)->get(['id' => $id]);
        // TODO

    }

    public function addPerfume(): void
    {
        $options = $this->getComponentsOptions();
        if (empty($_POST)) {
            $this->view('pages/add-perfume', ['componentsOptions' => $options]);
            return;
        }

        $name = strip_tags($_POST['name']);
        $description = strip_tags($_POST['description']);
        $gender = intval($_POST['gender']);
        $checkedComponents = $_POST['components'] ?? [];
        $componentsOptions = $this->getComponentsOptions();
        $perfumeData = ['name' => $name, 'description' => $description, 'gender' => $gender];
        $viewData = [...$perfumeData, 'options' => $componentsOptions, 'checkedComponents' => $checkedComponents];

        if (!$name) {
            $this->view('pages/add-perfume', ['errorMessage' => 'Perfume\'s name is required.', ...$viewData]);
            return;
        }

        /* Create perfume */
        $perfume = new Perfume;
        $alreadyExists = $perfume->get(['name' => $name]);
        if ($alreadyExists) {
            $this->view('pages/add-perfume', ['errorMessage' => 'A perfume with this name already exists.', ...$viewData]);
            return;
        }
        $perfume->save($perfumeData);

        /* Add components to perfume */
        $perfumeId = $perfume->get(['name' => $name])[0]['id'];
        $perfume->setId($perfumeId);
        $perfume->addComponentsToPerfume($checkedComponents);

        $this->view('pages/add-perfume', ['successMessage' => 'Perfume added.']);
    }

    private function getComponentsOptions(): string
    {
        $components = (new Component)->get();
        $options = implode('', array_map(function ($component) {
            $slug = str_replace(' ', '_', $component['name']);
            $str = '
            <input type="checkbox" class="form-check-input" id="' . $slug . '" name="components[]" value="' . $component['name'] . '">
            <label class="form-check-label" for="' . $slug . '">' . $component['name'] . '</label>
            ';
            return $str;
        }, $components));
        return $options;
    }

    public function deletePerfume(): void
    {
        $id = strip_tags($_GET['id']);
        $perfume = new Perfume;
        $perfume->delete($id);
        header('Location: /');
    }
}
