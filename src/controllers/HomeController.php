<?php

namespace App\controllers;

use App\models\Perfume;

class HomeController extends AbstractController
{
    public function index(): void
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
        $this->view('pages/home', $perfumes);
    }
}
