<?php

namespace App\controllers;

use App\models\Component;
use App\models\Perfume;

class HomeController extends AbstractController
{
    public function index(): void
    {
        $perfumes = $this->getPerfumes();
        $allComponents = $this->getAllComponents();
        $data = ['perfumes' => $perfumes, 'allComponents' => $allComponents];
        $this->view('pages/home', $data);
    }

    private function getPerfumes(): array
    {
        $perfumes = (new Perfume)->get();

        $perfumes = array_map(function ($perfume) {
            $components = (new Perfume)->getComponents($perfume['id']);
            $componentNames = [];
            foreach ($components as $key => $value) {
                array_push($componentNames, $value['name']);
            };
            return [...$perfume, ...['components' => $componentNames]];
        }, $perfumes);

        /* Filters */

        $selectors = [];
        if (!empty($_GET)) {
            $selectors = $_GET;
        };

        // by gender
        if (isset($selectors['gender'])) {
            $perfumes = array_filter($perfumes, fn ($perfume) => $selectors['gender'] == 0 ? $perfume : $perfume['gender'] == $selectors['gender']);
        }
        unset($selectors['gender']);

        // by components
        if (!empty($selectors)) {
            $perfumes = array_filter($perfumes, function ($perfume) use ($selectors) {
                foreach (array_keys($selectors) as $selector) {
                    return in_array($selector, $perfume['components']);
                }
            });
        }

        return $perfumes;
    }

    private function getAllComponents(): array
    {
        return (new Component)->getAllComponents();
    }
}
