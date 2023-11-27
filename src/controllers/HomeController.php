<?php

namespace App\controllers;

use App\models\Perfume;

class HomeController extends AbstractController
{
    public function index(): void
    {
        $perfumes = (new Perfume)->get();


        $this->view('pages/home', $perfumes);
    }
}
