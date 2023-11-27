<?php

namespace App\controllers;

class PerfumeController extends AbstractController
{
    public function index(): void
    {
        $this->view('pages/add-perfume');
    }
}
